<?php

namespace App\Console\Commands\News;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

use App\Modules\News\Interfaces\NewsSourceRepositoryInterface;
use App\Modules\News\Models\NewsSource;
use App\Modules\News\Interfaces\NewsRepositoryInterface;
use App\Modules\News\Jobs\ParseNewsSourceCompleteJob;
use App\Modules\News\Jobs\ParseNewsSourceJob;

class ParseNewsSources extends Command
{
    protected $signature = 'news:source:parse';

    /**
     * @var string
     */
    protected $description = 'Parse News sources';

    /**
     * @param NewsRepositoryInterface $newsRepository
     * @param NewsSourceRepositoryInterface $newsSourceRepository
     * @return void
     */
    public function handle(
        NewsRepositoryInterface $newsRepository,
        NewsSourceRepositoryInterface $newsSourceRepository,
    ): void
    {
        $jobs = [];

        /** @var NewsSource $source */
        foreach ($newsSourceRepository->getAllEnabled() as $source) {
            $jobs[] = new ParseNewsSourceJob($source->id);
        }

        $jobs[] = new ParseNewsSourceCompleteJob($newsRepository->count());

        Bus::chain($jobs)->dispatch();
    }
}
