<?php

namespace App\Modules\Users\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Controllers\Controller;
use App\Modules\Users\Http\Resources\UserListResource;
use App\Modules\Users\Http\Resources\UserResource;
use App\Modules\Users\Models\User;
use App\Modules\Users\Http\Queries\ListFilter;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserListResource::collection((QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::custom('query', new ListFilter),
                'status',
            ])
            ->allowedSorts([
                'id',
                'login',
                'status',
                'created_at',
            ])
            ->defaultSort('-created_at')
            ->paginate($request->get('perPage', 20))));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(UserResource::make($user));
    }
}
