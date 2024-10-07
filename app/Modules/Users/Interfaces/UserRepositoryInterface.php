<?php

namespace App\Modules\Users\Interfaces;

use App\Modules\Users\Enum\UserStatus;
use App\Modules\Users\Models\User;
use App\Modules\Users\Data\UserData;

interface UserRepositoryInterface
{
    /**
     * @param string $login
     * @return ?User
     */
    public function getByLogin(string $login): ?User;

    /**
     * @param UserData $data
     * @return User
     */
    public function create(UserData $data): User;

    /**
     * @param User $user
     * @param UserData $data
     * @return bool
     */
    public function update(User $user, UserData $data): bool;

    /**
     * @param User $user
     * @param UserStatus $status
     * @return bool
     */
    public function changeStatus(User $user, UserStatus $status): bool;
}
