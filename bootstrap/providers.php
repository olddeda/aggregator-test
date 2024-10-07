<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Services\FeedReader\FeedReaderServiceProvider::class,
    Illuminate\Notifications\NotificationServiceProvider::class,
    NotificationChannels\Telegram\TelegramServiceProvider::class,
];
