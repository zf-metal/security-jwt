<?php

namespace ZfMetal\SecurityJwt\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity;

class JwtIdentityFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $jwtDoctrineEntity = $container->get(JwtDoctrineIdentity::class);
        return new \ZfMetal\SecurityJwt\Controller\Plugin\JwtIdentity($jwtDoctrineEntity);
    }

}
