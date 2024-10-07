<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Enum\UserStatus;
use App\Modules\Users\Interfaces\UserRepositoryInterface;
use App\Modules\Users\Data\UserData;
use App\Modules\Users\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getByLogin(string $login): ?User
    {
        return User::query()->where('login', $login)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(UserData $data): User
    {
        return User::query()->create($data->all());
    }

    /**
     * @inheritDoc
     */
    public function update(User $user, UserData $data): bool
    {
        return $user->update($data->all());
    }

    /**
     * @inheritDoc
     */
    public function changeStatus(User $user, UserStatus $status): bool
    {
        return $user->update(['status' => $status]);
    }
}
