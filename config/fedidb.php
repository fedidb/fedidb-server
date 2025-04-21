<?php

return [
    'user_agent' => env('FDB_USER_AGENT', 'FediDB/0.5.0; +https://fedidb.org/crawler.html'),

    'discovery' => [
        'seeds' => env('FDB_DISCOVERY_SEEDS', ''),
    ],
];
