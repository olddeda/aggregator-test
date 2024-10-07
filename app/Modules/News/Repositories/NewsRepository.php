<?php

namespace App\Modules\News\Repositories;

use App\Modules\News\Interfaces\NewsRepositoryInterface;
use App\Modules\News\Data\NewsData;
use App\Modules\News\Models\News;

class NewsRepository implements NewsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getByGuid(string $guid): ?News
    {
        return News::query()->where('guid', $guid)->first();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return News::query()->count();
    }

    /**
     * @inheritDoc
     */
    public function create(NewsData $data): News
    {
        return News::query()->create($data->all());
    }

    /**
     * @inheritDoc
     */
    public function update(News $model, NewsData $data): bool
    {
        return $model->update($data->all());
    }
}
