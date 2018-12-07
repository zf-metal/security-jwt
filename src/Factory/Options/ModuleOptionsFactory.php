<?php

namespace ZfMetal\SecurityJwt\Factory\Options;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class ModuleOptionsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
         $config = $container->get('Config');
         
         return new \ZfMetal\SecurityJwt\Options\ModuleOptions(isset($config['zf-metal-security-jwt.options']) ? $config['zf-metal-security-jwt.options'] : array());
    }

}
