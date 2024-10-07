<?php

namespace App\Services\FeedReader;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

use Psr\SimpleCache\CacheInterface;

use SimplePie\SimplePie;

readonly class FeedReader
{
    /**
     * @param Container $app
     */
    public function __construct(
        private Container $app
    ) {}

    /**
     * @param $url
     * @param string $configuration
     * @param array $options
     * @return SimplePie
     * @throws BindingResolutionException
     */
    public function read($url, string $configuration = 'default', array $options = []): SimplePie
    {
        $sp = $this->app->make(SimplePie::class);

        $cache = Cache::store($this->readConfig($configuration, 'cache.driver', 'file'));
        if ($cache instanceof CacheInterface)  {
            $sp->set_cache($cache);
            $sp->set_cache_duration($this->readConfig($configuration, 'cache.duration', 3600));
        }

        $sp->enable_cache($cache instanceof CacheInterface);

        $sp->force_feed($this->readConfig($configuration, 'force-feed', false));

        $sp->enable_order_by_date($this->readConfig($configuration, 'order-by-date', false));

        if (! $this->readConfig($configuration, 'ssl-verify', true)) {
            $sp->set_curl_options([
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
        }

        if (isset($options['curl_options'])) {
            $sp->set_curl_options($options['curl_options']);
        }

        $sp->set_feed_url($url);

        $sp->init();

        return $sp;
    }

    /**
     * @param string $configuration
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    private function readConfig(string $configuration, string $name, mixed $default): mixed
    {
        return Config::get('feed-reader.profiles.' . $configuration . '.' . $name, $default);
    }
}
