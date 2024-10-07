<?php

namespace App\Modules\News\Interfaces;

use Illuminate\Database\Eloquent\Collection;

use App\Modules\News\Models\NewsSource;
use App\Modules\News\Data\NewsSourceData;

interface NewsSourceRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllEnabled(): Collection;

    /**
     * @param int $id
     * @return NewsSource
     */
    public function getById(int $id): NewsSource;

    /**
     * @param NewsSourceData $data
     * @return NewsSource
     */
    public function create(NewsSourceData $data): NewsSource;
}
