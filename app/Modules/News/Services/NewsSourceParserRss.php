<?php

namespace App\Modules\News\Services;

use DateTime;

use Illuminate\Contracts\Container\BindingResolutionException;

use App\Helpers\StringHelper;
use App\Services\FeedReader\FeedReaderFacade;
use App\Modules\News\Interfaces\NewsSourceParserInterface;
use App\Modules\News\Models\NewsSource;
use App\Modules\News\Data\NewsCategoryData;
use App\Modules\News\Data\NewsData;

readonly class NewsSourceParserRss implements NewsSourceParserInterface
{
    /**
     * @param NewsService $newsService
     */
    public function __construct(
        private NewsService $newsService,
    ) {}

    /**
     * @param NewsSource $source
     * @return void
     */
    public function parse(NewsSource $source): void
    {
        try {
            $result = FeedReaderFacade::read($source->url);

            $items = [];

            foreach ($result->get_items() as $item) {
                $guid = md5($source->id.$item->get_id());

                $items[] = NewsData::from([
                    'guid' => $guid,
                    'title' => $item->get_title(),
                    'link' => $item->get_link(),
                    'source' => $source->url,
                    'description' => $item->get_description(),
                    'published_at' => DateTime::createFromFormat(
                        'Y-m-d\TH:i:sP',
                        $item->get_date('Y-m-d\TH:i:sP')
                    ),
                    'categories' => array_map(
                        fn ($category) => new NewsCategoryData(StringHelper::ucfirst($category->get_term())),
                        $item->get_categories()
                    ),
                ]);
            }

            if (count($items)) {
                $this->newsService->multipleUpdate($items);
            }

        } catch (BindingResolutionException $e) {
            $source->last_error = $e->getMessage();
            $source->save();
        }
    }
}
