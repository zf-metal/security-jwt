<?php

namespace ZfMetal\Security;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controller_plugins' => [
        'factories' => [
          \ZfMetal\SecurityJwt\Controller\Plugin\ModuleOptions::class => \ZfMetal\SecurityJwt\Factory\Controller\Plugin\ModuleOptionsFactory::class,
        ],
        'aliases' => [
            'getSecurityJwtOptions' => \ZfMetal\SecurityJwt\Controller\Plugin\ModuleOptions::class
        ]
    ]
];
