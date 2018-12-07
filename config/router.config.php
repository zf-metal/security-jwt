<?php



use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'zf-metal-jwt-auth' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        'controller' => \ZfMetal\SecurityJwt\Controller\JwtController::class,
                        'action' => 'auth'
                    ]
                ],
            ]
        ]
    ]
];
