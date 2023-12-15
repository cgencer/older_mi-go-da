<?php

// config/enqueue.php

return [
    'default' => [
        'driver' => 'mysql',
        'dsn' => 'mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE'),
    ],
    'transport' => [
        'driver' => 'mysql',
        'dsn' => 'mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE'),
    ],
    'connections' => [
        'transport' => [
            'driver' => 'mysql',
            'dsn' => 'mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE'),
        ]
    ],
    'client' => [
        'transport' => [
            'driver' => 'mysql',
            'dsn' => 'mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE'),
        ],
        'client' => [
              'router_topic'    => 'default',
              'router_queue'    => 'default',
              'default_queue'   => 'default',
        ],
    ],
/*
        'interop' => [
            'driver' => 'interop',
            'dsn' => 'amqp+rabbitmq://guest:guest@localhost:5672/%2f',
        ],
    ],
*/

];