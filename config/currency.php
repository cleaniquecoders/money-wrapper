<?php

return [
    'default' => env('CURRENCY_DEFAULT', 'MY'),
    'default_swift_code' => env('CURRENCY_DEFAULT_SWIFT_CODE', 'MYR'),
    'MY'      => [
        'swift_code' => 'MYR',
        'symbol'     => 'RM',
    ],
    'US'      => [
        'swift_code' => 'USD',
        'symbol'     => '$',
    ],
];
