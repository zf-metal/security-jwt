<?php

namespace ZfMetal\SecurityJwt\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Security\Services\Impersonate;
use ZfMetal\SecurityJwt\Service\JwtService;

class JwtControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $jwtService = $container->get(JwtService::class);
       // $em = $container->get("doctrine.entitymanager.orm_default");

        return new \ZfMetal\SecurityJwt\Controller\JwtController($jwtService);
    }

}
