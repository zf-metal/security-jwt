<?php

namespace ZfMetal\SecurityJwt\Factory\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\SecurityJwt\Service\JwtDoctrineAuth;
use ZfMetal\SecurityJwt\Service\JwtService;


class JwtDoctrineAuthFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $em = $container->get(EntityManager::class);

        return new JwtDoctrineAuth($em);
    }

}
