<?php

namespace ZfMetal\SecurityJwt\Factory\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\SecurityJwt\Service\JwtService;


class JwtServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $options = $container->get('zf-metal-security-jwt.options');

        return new JwtService($options);
    }

}
