<?php

return [
    'service_manager' => [
        'factories' => [
            'zf-metal-security-jwt.options' => \ZfMetal\SecurityJwt\Factory\Options\ModuleOptionsFactory::class,
            \Jwt\Service\JwtService::class => \ZfMetal\Security\Factory\Services\JwtServiceFactory::class
        ],
        'aliases' => [


        ]
    ]
];

