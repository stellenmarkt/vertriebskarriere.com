<?php

return [
    'doctrine' =>[
        'connection' =>[
            'odm_default' =>[
                'connectionString' => 'mongodb://mongo1.hq.cross:27017/karriere24',
            ]
        ],
        'configuration' => [
            'odm_default' => [
                'default_db'    => 'karriere24',
            ]
        ],
    ],
    "core_options" => [
        'system_message_email' => "dev@yawik.dev",
    ]
];
