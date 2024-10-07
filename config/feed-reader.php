<?php

return [
    'profiles' => [
        'default' => [
            'cache' => [
                //  How long the cache is maintained in seconds
                'duration' => 3600,

                // Whether caching is enabled
                'enabled' => true,

                // The laravel cache driver used for caching
                'driver' => env('CACHE_DRIVER', 'file'),
            ],

            // Whether to force the data feed to be treated as an RSS feed
            'force-feed' => false,

            // Whether the RSS feed should have its output ordered by date.
            'order-by-date' => false,

            // Whether it should verify SSL, set false to make it work with self-signed certificates
            'ssl-verify' => true,
        ],
    ],
];
