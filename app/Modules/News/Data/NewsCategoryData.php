<?php

namespace App\Modules\News\Data;

use Spatie\LaravelData\Data;

class NewsCategoryData extends Data
{
    public function __construct(
        public string $title,
    ) {}
}
