<?php

namespace ZfMetal\SecurityJwt;

use Zend\ModuleManager\ModuleManager;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements
    ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface
{

    /**
     * @var \Zend\Mvc\Application
     */
    private $app;

    /**
     * @var \Zend\Mvc\MvcEvent
     */
    private $mvcEvent;


    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $mvcEvent)
    {
        $this->mvcEvent = $mvcEvent;
        $this->app = $mvcEvent->getApplication();

    }




    private function getEventManager()
    {
        return $this->app->getEventManager();
    }

    private function getServiceManager()
    {
        return $this->app->getServiceManager();
    }


}
