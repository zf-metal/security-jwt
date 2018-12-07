<?php

namespace Test\Controller;

use PHPUnit\Framework\TestCase;
use Zend\Http\Request;
use ZfMetal\SecurityJwt\Controller\JwtController;
use ZfMetal\SecurityJwt\Options\ModuleOptions;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class JwtControllerTest extends AbstractHttpControllerTestCase
{
    protected $em;
    protected $jwtService;

    /**
     * @var JwtController
     */
    protected $controller;

    public function setUp()
    {
        //$this->em = $this->createMock(\Doctrine\ORM\EntityManager::class);
        //$options = new ModuleOptions();
        //$this->jwtService = new JwtService($options);
        //$this->controller = new JwtController($this->jwtService, $this->em);

        $this->setApplicationConfig(
            include './../config/application.config.php'
        );

        parent::setUp();
    }

    public function tearDown()
    {

    }

    public function testAuthAction()
    {

        $this->dispatch("/auth");
        $this->assertResponseStatusCode(200);
    }

}
