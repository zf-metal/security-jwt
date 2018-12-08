<?php

namespace ZfMetal\SecurityJwt\Factory\Controller;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\SecurityJwt\Service\DoctrineAuth;
use ZfMetal\SecurityJwt\Service\JwtService;

class ProtectedControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new \ZfMetal\SecurityJwt\Controller\ProtectedController();
    }

}
