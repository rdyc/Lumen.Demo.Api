<?php

return [
    'storage' => [
        'pull' => [
            'path' => env('SYNC_PULL_PATH', 'sync/pull/')
        ],
        'push' => [
            'path' => env('SYNC_PUSH_PATH', 'sync/push/')
        ]
    ]
];