<?php



use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'zf-metal-jwt-auth' => [
                'type' => \Zend\Router\Http\Method::class,
                'options' => [
                    'route' => '/auth',
                    'verb' => 'post',
                    'defaults' => [
                        'controller' => \ZfMetal\SecurityJwt\Controller\JwtController::class,
                        'action' => 'auth'
                    ]
                ],
            ],
            'zf-metal-jwt-protected-action' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/protected',
                    'defaults' => [
                        'controller' => \ZfMetal\SecurityJwt\Controller\ProtectedController::class,
                        'action' => 'protected'
                    ]
                ],
            ]
        ]
    ]
];
