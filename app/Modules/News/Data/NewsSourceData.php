<?php

namespace App\Modules\News\Data;

use Spatie\LaravelData\Data;

use App\Modules\News\Enums\NewsSourceStatus;
use App\Modules\News\Enums\NewsSourceType;

class NewsSourceData extends Data
{
    /**
     * @param NewsSourceType $type
     * @param NewsSourceStatus $status
     * @param string $url
     */
    public function __construct(
        public NewsSourceType $type,
        public NewsSourceStatus $status,
        public string $url,
    ) {}
}
