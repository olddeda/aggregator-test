<?php

namespace App\Modules\Users\Enum;

use App\Traits\EnumTrait;

enum UserStatus: string
{
    use EnumTrait;

    case DRAFT = 'draft';
    case DISABLED = 'disabled';
    case ENABLED = 'enabled';
}
