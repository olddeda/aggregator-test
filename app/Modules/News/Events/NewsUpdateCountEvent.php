<?php

namespace App\Modules\News\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsUpdateCountEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param int $count
     */
    public function __construct(
        public int $count
    ) {}

    public function broadcastAs(): string
    {
        return 'added.count';
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('news'),
        ];
    }

    /**
     * @return int[]
     */
    public function broadcastWith(): array
    {
        return [
            'count' => $this->count,
        ];
    }
}
