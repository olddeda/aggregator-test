<?php

namespace App\Modules\News\Jobs;

use Exception;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Modules\News\Enums\NewsSourceType;
use App\Modules\News\Enums\NewsSourceStatus;
use App\Modules\News\Interfaces\NewsSourceRepositoryInterface;
use App\Modules\News\Services\NewsSourceParserRss;

class ParseNewsSourceJob implements ShouldQueue
{
    use Queueable;

    /**
     * @param int $news_source_id
     */
    public function __construct(
        private readonly int $news_source_id,
    ) {}

    /**
     * @param NewsSourceRepositoryInterface $repository
     * @param NewsSourceParserRss $parserRss
     * @return void
     * @throws Exception
     */
    public function handle(
        NewsSourceRepositoryInterface $repository,
        NewsSourceParserRss $parserRss,
    ): void
    {
        $newsSource = $repository->getById($this->news_source_id);

        if ($newsSource->status !== NewsSourceStatus::ENABLED) {
            $newsSource->last_error = 'News source is not enabled';
            $newsSource->save();

            return;
        }

        switch ($newsSource->type) {
            case NewsSourceType::RSS:
                $parserRss->parse($newsSource);
                break;
            default:
                 break;
        }
    }
}
