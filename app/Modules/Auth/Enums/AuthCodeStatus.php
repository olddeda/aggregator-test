<?php

namespace App\Modules\Auth\Enums;

use App\Traits\EnumTrait;

enum AuthCodeStatus: string
{
    use EnumTrait;

    case NEW = 'new';
    case USED = 'used';
    case EXPIRED = 'expired';
}
