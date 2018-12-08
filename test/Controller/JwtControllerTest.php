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

class JwtControllerTest extends AbstractHttpControllerTestCase
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
     * Verico que con metodo GET obtengo 404 not found
     */
    public function testAuthActionGet404notFound()
    {
        $this->dispatch("/auth", "GET", ['username' => 'pargento']);
        $this->assertResponseStatusCode(404);
    }

    /**
     * Verico que con metodo POST obtengo 200 ok
     */
    public function testAuthActionPost200ok()
    {
        $this->dispatch("/auth", "POST");
        $this->assertResponseStatusCode(200);
    }

    /**
     * Verico que falta los parametros usuario y password
     */
    public function testAuthActionMissingParams()
    {
        $this->dispatch("/auth", "POST");
        $this->assertResponseStatusCode(200);

        $json = [
            'success' => false,
            'message' => "Missing Params. username and password required."
        ];

        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($json));
    }


    /**
     * Verico credenciales invalidas
     */
    public function testAuthActionInvalidCredentials()
    {
        $this->dispatch("/auth", "POST", ['username' => 'userInvalid', 'password' => 'invalidPassword']);
        $this->assertResponseStatusCode(200);

        $json = [
            'success' => false,
            'message' => "Invalid Credentials"
        ];

        $jsonResponse = $this->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString($jsonResponse, json_encode($json));
    }

    /**
     * Verifico credenciales validas
     */
    public function testAuthActionValidCredentials()
    {
        $this->dispatch("/auth", "POST", ['username' => 'userValid', 'password' => 'validPassword']);

        $this->assertResponseStatusCode(200);


        $json = [
            'success' => true,
            'message' => 'Authentication successful',
        ];

        $jsonResponse = $this->getResponse()->getContent();
        $jsonDecode = json_decode($jsonResponse);

        $this->assertEquals($jsonDecode->success,$json['success']);
        $this->assertEquals($jsonDecode->message,$json['message']);
    }

}
