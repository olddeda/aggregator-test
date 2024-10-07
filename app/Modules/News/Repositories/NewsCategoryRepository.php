<?php

namespace App\Modules\News\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Modules\News\Interfaces\NewsCategoryRepositoryInterface;
use App\Modules\News\Data\NewsCategoryData;
use App\Modules\News\Models\NewsCategory;

class NewsCategoryRepository implements NewsCategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return NewsCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function create(NewsCategoryData $data): NewsCategory
    {
        return NewsCategory::query()->create($data->all());
    }
}
