<?php

namespace App\Modules\News\Interfaces;

use App\Modules\News\Models\NewsSource;

interface NewsSourceParserInterface
{
    /**
     * @param NewsSource $source
     * @return void
     */
    public function parse(NewsSource $source): void;
}
