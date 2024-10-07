<?php

namespace App\Modules\News\Data;

use DateTimeInterface;

use Spatie\LaravelData\Data;

class NewsData extends Data
{
    /**
     * @param string $guid
     * @param string $title
     * @param string $link
     * @param string $source
     * @param string $description
     * @param DateTimeInterface $published_at
     * @param NewsCategoryData[] $categories
     */
    public function __construct(
        public string $guid,
        public string $title,
        public string $link,
        public string $source,
        public string $description,
        public DateTimeInterface $published_at,
        public array $categories,
    ) {}
}
