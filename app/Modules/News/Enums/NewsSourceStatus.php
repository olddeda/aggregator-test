<?php

namespace App\Modules\News\Enums;

use App\Traits\EnumTrait;

enum NewsSourceStatus: string
{
    use EnumTrait;

    case DISABLED = 'disabled';
    case ENABLED = 'enabled';
}
