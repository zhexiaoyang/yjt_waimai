<?php

return [
    'meituan' => [
        'app_id' => '2453',
        'secret' => '8a1e69b45cdd68c665e91b2ee9245a4f'
    ],
    'log' => [
        'name' => 'waimai',
        'file' => storage_path('logs/waimai-'.date("Y-m-d").'.log'),
        'level' => 'debug',
        'permission' => 0777
    ]
];