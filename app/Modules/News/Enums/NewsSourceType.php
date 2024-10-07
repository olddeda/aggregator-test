<?php

namespace App\Modules\News\Enums;

use App\Traits\EnumTrait;

enum NewsSourceType: string
{
    use EnumTrait;

    case RSS = 'rss';
}
