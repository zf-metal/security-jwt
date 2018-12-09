<?php


return [
    'controller_plugins' => [
        'factories' => [
            \ZfMetal\SecurityJwt\Controller\Plugin\ModuleOptions::class => \ZfMetal\SecurityJwt\Factory\Controller\Plugin\ModuleOptionsFactory::class,
            \ZfMetal\SecurityJwt\Controller\Plugin\JwtIdentity::class => \ZfMetal\SecurityJwt\Factory\Controller\Plugin\JwtIdentityFactory::class
        ],
        'aliases' => [
            'getSecurityJwtOptions' => \ZfMetal\SecurityJwt\Controller\Plugin\ModuleOptions::class,
            'getJwtIdentity' => \ZfMetal\SecurityJwt\Controller\Plugin\JwtIdentity::class
        ]
    ]
];
