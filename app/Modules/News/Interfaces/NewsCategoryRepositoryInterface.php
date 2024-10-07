<?php

namespace App\Modules\News\Interfaces;

use Illuminate\Database\Eloquent\Collection;

use App\Modules\News\Data\NewsCategoryData;
use App\Modules\News\Models\NewsCategory;

interface NewsCategoryRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param NewsCategoryData $data
     * @return NewsCategory
     */
    public function create(NewsCategoryData $data): NewsCategory;
}
