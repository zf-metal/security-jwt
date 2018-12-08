<?php

namespace Test\Controller;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceManager;
use ZfMetal\SecurityJwt\Controller\JwtController;
use ZfMetal\SecurityJwt\Options\ModuleOptions;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class JwtControllerTest extends AbstractHttpControllerTestCase
{
    protected $mockedEm;
    protected $jwtService;

    /**
     * @var JwtController
     */
    protected $controller;

    /**
     * Inicializo el MVC
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__.'/../config/application.config.php'
        );
        parent::setUp();
        $this->configureServiceManager($this->getApplicationServiceLocator());
    }

    /**
     * Mockeo el EntityManager sobre el contenedor de servicios
     * @param ServiceManager $services
     *
     */
    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);
        $this->mockedEm = $this->createMock(EntityManager::class);
        $services->setService(EntityManager::class, $this->mockedEm);
        $services->setAllowOverride(false);
    }


    /**
     * Verico que con metodo GET obtengo 404 not found
     *
     */
    public function testAuthActionGet404()
    {
        $this->dispatch("/auth","GET",['username' => 'pargento']);
        $this->assertResponseStatusCode(404);
    }

    /**
     * Verifico que con metodo POST obtengo 200 ok
     */
    public function testAuthActionPost200()
    {
        $this->dispatch("/auth","POST",['username' => 'pargento']);
        $this->assertResponseStatusCode(200);
    }

}
