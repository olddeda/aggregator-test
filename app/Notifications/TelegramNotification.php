<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notification;

use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification implements ShouldQueue
{
    use Queueable, Dispatchable;

    /**
     * @param string $text
     * @param ?int $channel_id
     */
    public function __construct(
        public string $text,
        public ?int $channel_id = null,
    ) {}

    /**
     * @return string[]
     */
    public function via(): array
    {
        return ['telegram'];
    }

    /**
     * @param $notifiable
     * @return TelegramMessage
     */
    public function toTelegram($notifiable): TelegramMessage
    {
        $channelId = $this->channel_id ?? config('services.telegram-bot-api.channel_id');

        $message = TelegramMessage::create();
        $message->to($channelId)->content($this->text);

        return $message;
    }
}
