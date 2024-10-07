<?php

namespace App\Modules\Auth\Repositories;

use Carbon\Carbon;

use App\Modules\Auth\Interfaces\AuthCodeRepositoryInterface;
use App\Modules\Auth\Models\AuthCode;
use App\Modules\Auth\Data\AuthCodeData;
use App\Modules\Auth\Enums\AuthCodeStatus;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAvailableByLogin(string $login): ?AuthCode
    {
        return AuthCode::query()
            ->where('login', $login)
            ->where('status', AuthCodeStatus::NEW)
            ->where('available_at', '>=', Carbon::now())
            ->orderBy('available_at', 'desc')
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function getAvailableByLoginAndCode(string $login, string $code): ?AuthCode
    {
        return AuthCode::query()
            ->where('login', $login)
            ->where('code', $code)
            ->where('status', AuthCodeStatus::NEW)
            ->orderBy('available_at', 'desc')
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function create(AuthCodeData $data): AuthCode
    {
        return AuthCode::query()->create($data->all());
    }

    /**
     * @inheritDoc
     */
    public function markAsUsed(AuthCode $authCode): bool
    {
        $authCode->status = AuthCodeStatus::USED;
        return $authCode->save();
    }

    /**
     * @inheritDoc
     */
    public function updateStatusForExpired(): bool
    {
        return AuthCode::query()
            ->where('available_at', '<', Carbon::now())
            ->where('status', AuthCodeStatus::NEW)
            ->update([
                'status' => AuthCodeStatus::EXPIRED
            ]);
    }
}
