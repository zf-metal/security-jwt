<?php

namespace ZfMetal\SecurityJwt\Factory\Controller;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\SecurityJwt\Service\JwtService;

class JwtControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $jwtService = $container->get(JwtService::class);
        $em = $container->get(EntityManager::class);

        return new \ZfMetal\SecurityJwt\Controller\JwtController($jwtService,$em);
    }

}
