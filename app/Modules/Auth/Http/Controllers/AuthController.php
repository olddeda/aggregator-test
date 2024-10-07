<?php

namespace App\Modules\Auth\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Controllers\Controller;
use App\Notifications\TelegramNotification;
use App\Modules\Auth\Models\AuthCode;
use App\Modules\Auth\Data\AuthData;
use App\Modules\Auth\Data\AuthCodeData;
use App\Modules\Auth\Events\AuthEvent;
use App\Modules\Auth\Enums\AuthType;
use App\Modules\Auth\Enums\AuthCodeStatus;
use App\Modules\Auth\Interfaces\AuthCodeRepositoryInterface;
use App\Modules\Auth\Http\Resources\AuthCodeListResource;
use App\Modules\Users\Models\User;
use App\Modules\Users\Enum\UserStatus;
use App\Modules\Users\Interfaces\UserRepositoryInterface;
use App\Modules\Users\Data\UserData;
use App\Modules\Users\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
     * @param AuthCodeRepositoryInterface $authCodeRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private readonly AuthCodeRepositoryInterface $authCodeRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return AuthCodeListResource::collection((QueryBuilder::for(AuthCode::class)
            ->allowedFilters([
                'login',
                'code',
                'status'
            ])
            ->allowedSorts([
                'id',
                'login',
                'code',
                'status',
            ])
            ->defaultSort('-created_at')
            ->paginate($request->get('perPage', 20))));
    }

    /**
     * @param AuthData $data
     * @return JsonResponse
     */
    public function auth(AuthData $data): JsonResponse
    {
        /** @var AuthCode $user */
        $authCode = $this->authCodeRepository->getAvailableByLogin($data->login);

        if ($authCode) {
            $availableAt = Carbon::parse($authCode->available_at);
            $seconds = Carbon::now()->diffInSeconds($availableAt);

            abort(425, __('auth.error.code.exists', [
                'second' => (int)$seconds.' '.trans_choice('plural.seconds', $seconds),
            ]));
        }

        $code = Str::password(config('auth.code.digits'), false, true, false);

        $authCode = $this->authCodeRepository->create(AuthCodeData::from([
            'login' => $data->login,
            'code' => $code,
            'status' => AuthCodeStatus::NEW,
            'available_at' => Carbon::now()->addSeconds(config('auth.code.expire')),
        ]));

        $user = $this->userRepository->getByLogin($authCode->login);
        if (is_null($user)) {
            $this->userRepository->create(UserData::from([
                'login' => $authCode->login,
                'status' => UserStatus::DRAFT,
            ]));
        }

        $authCode->notify(new TelegramNotification(
            text: __('auth.notification.code.text', [
                'login' => $data->login,
                'code' => $code,
            ])
        ));

        $response = response()->json([
            'seconds' => config('auth.code.expire'),
            'digits' => config('auth.code.digits'),
        ]);

        if (app()->isLocal() || app()->runningUnitTests()) {
            $response->header('X-Auth-Code', $code);
        }

        return $response;
    }

    /**
     * @param AuthCodeData $data
     * @return JsonResponse
     */
    public function authCode(AuthCodeData $data): JsonResponse
    {
        $authCode = $this->authCodeRepository->getAvailableByLoginAndCode($data->login, $data->code);

        if (is_null($authCode)) {
            abort(404, __('auth.error.code.not_found'));
        }

        if ($authCode->available_at < Carbon::now()) {
            abort(404, __('auth.error.code.expire'));
        }

        $this->authCodeRepository->markAsUsed($authCode);

        $user = $this->userRepository->getByLogin($data->login);
        if (is_null($user)) {
            abort(404, __('auth.error.user.not_found'));
        }

        $authType = $user->status === UserStatus::DRAFT ? AuthType::SIGNUP : AuthType::LOGIN;

        if ($user->status === UserStatus::DRAFT) {
            $this->userRepository->changeStatus($user, UserStatus::ENABLED);
        }

        AuthEvent::dispatch($authType, $user->login);

        $token = $user->createToken($data->login)->plainTextToken;

        return response()->json([
            'user' => UserResource::make($user),
            'token' => $token,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json(UserResource::make($request->user()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->noContent();
    }
}
