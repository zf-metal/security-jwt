<?php

namespace ZfMetal\SecurityJwt\Factory\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\SecurityJwt\Service\DoctrineAuth;
use ZfMetal\SecurityJwt\Service\JwtService;


class DoctrineAuthFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $em = $container->get(EntityManager::class);

        return new DoctrineAuth($em);
    }

}
