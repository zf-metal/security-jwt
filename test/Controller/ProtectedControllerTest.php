<?php

namespace Test\Controller;

use Doctrine\ORM\EntityManager;

use PHPUnit\Framework\TestCase;
use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceManager;
use ZfMetal\Security\Repository\UserRepository;
use ZfMetal\SecurityJwt\Controller\JwtController;
use ZfMetal\SecurityJwt\Options\ModuleOptions;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ProtectedControllerTest extends AbstractHttpControllerTestCase
{


    protected $mockedEm;
    protected $mockedUserRepository;

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
            include __DIR__ . '/../config/application.config.php'
        );
        parent::setUp();
        $this->configureServiceManager($this->getApplicationServiceLocator());
    }

    /**
     * Mockeo el EntityManager sobre el contenedor de servicios
     * @param ServiceManager $services
     */
    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);
        $services->setService(EntityManager::class, $this->getMockEntityManager());
        $services->setAllowOverride(false);
    }

    public function getMockEntityManager()
    {
        //Mock EntityManager
        $this->mockedEm = $this->createMock(EntityManager::class);

        //Mock UserRepositorey
        $this->mockedUserRepository = $this->createMock(UserRepository::class);

        //Mock method getRepository
        $this->mockedEm->method('getRepository')
            ->willReturn($this->mockedUserRepository);

        //Mock method getAuthenticateByEmailOrUsername
        $map = [
            ['userInvalid', null],
            ['userValid', $this->getMockUser()]
        ];
        $this->mockedUserRepository->method('getAuthenticateByEmailOrUsername')
            ->will($this->returnValueMap($map));

        return $this->mockedEm;
    }

    public function getMockUser()
    {
        $user = new \ZfMetal\Security\Entity\User();
        $user->setUsername("userValid");
        $user->setActive(true);
        $bcrypt = new Bcrypt(['cost' => 12]);
        $password = $bcrypt->create("validPassword");
        $user->setPassword($password);
        return $user;
    }

    /**
     * Verifico un controlador protegido sin token
     */
    public function testProtectedControllerWhithoutToken()
    {
        $this->dispatch("/protected", "POST");

        $this->assertResponseStatusCode(401);
    }

}
