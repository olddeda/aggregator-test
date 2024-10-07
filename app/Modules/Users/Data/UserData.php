<?php

namespace App\Modules\Users\Data;

use Spatie\LaravelData\Data;

use App\Modules\Users\Enum\UserStatus;

class UserData extends Data
{
    /**
     * @param ?string $login
     * @param ?UserStatus $status
     */
    public function __construct(
        public ?string $login,
        public ?UserStatus $status,
    ) {}
}
