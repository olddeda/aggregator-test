<?php

namespace App\Modules\News\Services;

use App\Modules\News\Data\NewsCategoryData;
use App\Modules\News\Data\NewsData;
use App\Modules\News\Models\NewsCategory;
use App\Modules\News\Repositories\NewsCategoryRepository;
use App\Modules\News\Repositories\NewsRepository;

class NewsService
{
    /**
     * @var ?array
     */
    private ?array $categories = null;

    public function __construct(
        private readonly NewsRepository $newsRepository,
        private readonly NewsCategoryRepository $newsCategoryRepository,
    )
    {}

    /**
     * @param NewsData[] $items
     * @return void
     */
    public function multipleUpdate(array $items): void
    {
        foreach ($items as $itemData) {
            $news = $this->newsRepository->getByGuid($itemData->guid);

            if (is_null($news)) {
                $news = $this->newsRepository->create($itemData);
            }
            else {
                $this->newsRepository->update($news, $itemData);
            }

            $categoriesIds = array_map(function ($categoryData) {
                return $this->findOrCreateCategory($categoryData)->id;
            }, $itemData->categories);

            $news->categories()->sync($categoriesIds);
        }
    }

    /**
     * @param NewsCategoryData $categoryData
     * @return NewsCategory
     */
    private function findOrCreateCategory(NewsCategoryData $categoryData): NewsCategory
    {
        if (!is_null($this->categories)) {
            $this->categories = $this->newsCategoryRepository->getAll()
                ->keyBy('title')
                ->all();
        }

        if (!isset($this->categories[$categoryData->title])) {
            $this->categories[$categoryData->title] = $this->newsCategoryRepository->create($categoryData);
        }

        return $this->categories[$categoryData->title];
    }
}
