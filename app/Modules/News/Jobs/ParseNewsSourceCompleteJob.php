<?php

namespace App\Modules\News\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Modules\News\Events\NewsUpdateCountEvent;
use App\Modules\News\Interfaces\NewsRepositoryInterface;

class ParseNewsSourceCompleteJob implements ShouldQueue
{
    use Queueable;

    /**
     * @param int $old_count
     */
    public function __construct(
        private readonly int $old_count,
    ) {}

    /**
     * @param NewsRepositoryInterface $repository
     * @return void
     */
    public function handle(
        NewsRepositoryInterface $repository,
    ): void
    {
        $newCount = $repository->count() - $this->old_count;

        NewsUpdateCountEvent::dispatch($newCount);
    }
}
