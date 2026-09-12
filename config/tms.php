<?php

return [
    'demo_mode' => env('TMS_DEMO_MODE', false),
    'demo_password' => env('TMS_DEMO_PASSWORD'),
    'timezone' => 'Asia/Kolkata',
    'navigation' => [
        'GM' => ['tasks' => 'Tasks', 'verification' => 'Verification', 'reports' => 'Report'],
        'AM' => ['tasks' => 'Tasks', 'verification' => 'Verification', 'reports' => 'Report'],
        'BDE' => ['tasks' => 'Tasks'],
    ],
];
