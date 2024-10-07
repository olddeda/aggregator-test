<?php

namespace App\Modules\News\Interfaces;

use App\Modules\News\Data\NewsData;
use App\Modules\News\Models\News;

interface NewsRepositoryInterface
{
    /**
     * @param string $guid
     * @return ?News
     */
    public function getByGuid(string $guid): ?News;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @param NewsData $data
     * @return News
     */
    public function create(NewsData $data): News;

    /**
     * @param News $model
     * @param NewsData $data
     * @return bool
     */
    public function update(News $model, NewsData $data): bool;
}
