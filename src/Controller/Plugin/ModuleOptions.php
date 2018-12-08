<?php
/**
 * Created by PhpStorm.
 * User: afurgeri
 * Date: 14/03/17
 * Time: 12:56
 */

namespace ZfMetal\SecurityJwt\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ModuleOptions extends AbstractPlugin
{
    /**
     * @var \ZfMetal\SecurityJwt\Options\ModuleOptions
     */
    private $moduleOptions;

    /**
     * ModuleOptions constructor.
     * @param $moduleOptions
     */
    public function __construct(\ZfMetal\SecurityJwt\Options\ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return \ZfMetal\SecurityJwt\Options\ModuleOptions
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    function __invoke()
    {
        return $this->getModuleOptions();
    }
}