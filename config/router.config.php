<?php

use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'zf-metal-jwt-auth' => [
                'type' => Literal::class,
                'may_terminate' => false,
                'options' => [
                    'route' => '/auth',
                ],
                'child_routes' => [
                    'auth' => [
                        'type' => \Zend\Router\Http\Method::class,
                        'may_terminate' => true,
                        'options' => [
                            'verb' => 'post',
                            'defaults' => [
                                'controller' => \ZfMetal\SecurityJwt\Controller\JwtController::class,
                                'action' => 'auth'
                            ]
                        ],
                    ],
                ]
            ],
            'zf-metal-jwt-identity' => [
                'type' => Literal::class,
                'may_terminate' => false,
                'options' => [
                    'route' => '/my-identity',
                ],
                'child_routes' => [
                    'get' => [
                        'type' => \Zend\Router\Http\Method::class,
                        'may_terminate' => true,
                        'options' => [
                            'verb' => 'get',
                            'defaults' => [
                                'controller' => \ZfMetal\SecurityJwt\Controller\JwtController::class,
                                'action' => 'my-identity'
                            ]
                        ],
                    ],
                ]
            ],
            'zf-metal-jwt-protected-inheritance' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/protected',
                    'defaults' => [
                        'controller' => \ZfMetal\SecurityJwt\Controller\ProtectedController::class,
                        'action' => 'protected'
                    ]
                ],
            ],
            'zf-metal-jwt-protected-trait' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/protected-trait',
                    'defaults' => [
                        'controller' => \ZfMetal\SecurityJwt\Controller\ProtectedTraitController::class,
                        'action' => 'protected'
                    ]
                ],
            ]
        ]
    ]
];
