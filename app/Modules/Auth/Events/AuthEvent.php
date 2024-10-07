<?php

namespace App\Modules\Auth\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Modules\Auth\Enums\AuthType;

class AuthEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param AuthType $authType
     * @param string $login
     */
    public function __construct(
        public AuthType $authType,
        public string $login
    ) {}

    public function broadcastAs(): string
    {
        return 'auth';
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('users'),
        ];
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'type' => $this->authType->value,
            'login' => $this->login,
        ];
    }
}
