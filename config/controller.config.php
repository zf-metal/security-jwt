<?php



return [
    'controllers' => [
        'factories' => [
            \ZfMetal\SecurityJwt\Controller\JwtController::class => \ZfMetal\SecurityJwt\Factory\Controller\JwtControllerFactory::class,
            \ZfMetal\SecurityJwt\Controller\ProtectedController::class => \ZfMetal\SecurityJwt\Factory\Controller\ProtectedControllerFactory::class,
            \ZfMetal\SecurityJwt\Controller\ProtectedTraitController::class => \ZfMetal\SecurityJwt\Factory\Controller\ProtectedTraitControllerFactory::class
        ]
    ]
];
