<?php

namespace App\Modules\Auth\Enums;

use App\Traits\EnumTrait;

enum AuthType: string
{
    use EnumTrait;

    case SIGNUP = 'signup';
    case LOGIN = 'login';
}
