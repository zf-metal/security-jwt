<?php

namespace ZfMetal\SecurityJwt\Factory\Services;

use Interop\Container\ContainerInterface;
use Jwt\Service\JwtService;
use Zend\ServiceManager\Factory\FactoryInterface;


class JwtServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $options = $container->get('zf-metal-security-jwt.options');

        return new JwtService($options);
    }

}
