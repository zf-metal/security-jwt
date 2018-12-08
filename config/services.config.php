<?php

return [
    'service_manager' => [
        'factories' => [
            'zf-metal-security-jwt.options' => \ZfMetal\SecurityJwt\Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\SecurityJwt\Service\JwtService::class => \ZfMetal\SecurityJwt\Factory\Service\JwtServiceFactory::class,
            \ZfMetal\SecurityJwt\Service\DoctrineAuth::class => \ZfMetal\SecurityJwt\Factory\Service\DoctrineAuthFactory::class
        ]
    ]
];

