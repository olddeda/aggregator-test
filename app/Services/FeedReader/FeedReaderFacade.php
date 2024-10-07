<?php

namespace App\Services\FeedReader;

use Illuminate\Support\Facades\Facade;

use SimplePie\SimplePie;

/**
 * @method static SimplePie read(string $url)
 */
class FeedReaderFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'feed-reader';
    }
}
