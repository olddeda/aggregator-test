<?php

namespace App\Services\FeedReader;

use Illuminate\Support\ServiceProvider;

class FeedReaderServiceProvider extends ServiceProvider
{
	/**
	 * @return void
	 */
	public function register(): void
	{
        $this->app->bind('feed-reader', function($app) {
            return new FeedReader($app);
        });
	}
}
