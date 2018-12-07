<?php

namespace ZfMetal\Security;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'zf-metal-jwt' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/oauth',
                    'defaults' => [
                        'controller' => Controller\JwtController::class,
                        'action' => 'oauth'
                    ]
                ],
            ]
        ]
    ]
];
