<?php

namespace App\Modules\Auth\Interfaces;

use App\Modules\Auth\Data\AuthCodeData;
use App\Modules\Auth\Models\AuthCode;

interface AuthCodeRepositoryInterface
{
    /**
     * @param string $login
     * @return ?AuthCode
     */
    public function getAvailableByLogin(string $login): ?AuthCode;

    /**
     * @param string $login
     * @param string $code
     * @return ?AuthCode
     */
    public function getAvailableByLoginAndCode(string $login, string $code): ?AuthCode;

    /**
     * @param AuthCodeData $data
     * @return AuthCode
     */
    public function create(AuthCodeData $data): AuthCode;

    /**
     * @param AuthCode $authCode
     * @return bool
     */
    public function markAsUsed(AuthCode $authCode): bool;

    /**
     * @return bool
     */
    public function updateStatusForExpired(): bool;
}
