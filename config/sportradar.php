<?php

return [

    'sports' => [

        'soccer' => [

            'enabled' => true,

            'client' => \AxlMedia\SportradarSdk\SoccerExtendedV4::class,

            'keys' => [
                'production' => env('SPORTRADAR_SOCCER_PRODUCTION_KEY', 'some-key'),
                'trial' => env('SPORTRADAR_SOCCER_TRIAL_KEY', 'some-trial-key'),
            ],

            /* 'stream' => [
                'enabled' => true,
                'key' => env('SPORTRADAR_SOCCER_STREAM_API_KEY', 'some-stream-key'),
                'access_level' => 'p',
            ], */

        ],

    ],

    /* 'odds' => [

        'enabled' => true,

        'version' => env('SPORTRADAR_ODDS_VERSION'),

        'keys' => [
            'p' => env('SPORTRADAR_ODDS_PRODUCTION_KEY'),
            't' => env('SPORTRADAR_ODDS_TRIAL_KEY'),
        ],

    ], */

];
