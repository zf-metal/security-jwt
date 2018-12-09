<?php

return [
    'service_manager' => [
        'factories' => [
            'zf-metal-security-jwt.options' => \ZfMetal\SecurityJwt\Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\SecurityJwt\Service\JwtService::class => \ZfMetal\SecurityJwt\Factory\Service\JwtServiceFactory::class,
            \ZfMetal\SecurityJwt\Service\JwtDoctrineAuth::class => \ZfMetal\SecurityJwt\Factory\Service\JwtDoctrineAuthFactory::class,
            \ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity::class => \ZfMetal\SecurityJwt\Factory\Service\JwtDoctrineIdentityFactory::class
        ]
    ]
];

