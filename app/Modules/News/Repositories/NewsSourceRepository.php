<?php

namespace App\Modules\News\Repositories;

use App\Modules\News\Data\NewsSourceData;
use Illuminate\Database\Eloquent\Collection;

use App\Modules\News\Enums\NewsSourceStatus;
use App\Modules\News\Interfaces\NewsSourceRepositoryInterface;
use App\Modules\News\Models\NewsSource;

class NewsSourceRepository implements NewsSourceRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllEnabled(): Collection
    {
        return NewsSource::query()
            ->where('status', NewsSourceStatus::ENABLED)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): NewsSource
    {
        return NewsSource::query()->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function create(NewsSourceData $data): NewsSource
    {
        return NewsSource::query()->create($data->all());
    }
}
