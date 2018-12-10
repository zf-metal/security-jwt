<?php

namespace Test\Controller;

use Doctrine\ORM\EntityManager;

use PHPUnit\Framework\TestCase;
use Test\Service\JwtServiceTest;
use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceManager;
use ZendTest\Http\HeadersTest;
use ZfMetal\Security\Repository\UserRepository;
use ZfMetal\SecurityJwt\Controller\JwtController;
use ZfMetal\SecurityJwt\Options\ModuleOptions;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class JwtControllerTest
 * @method Request getRequest()
 * @package Test\Controller
 */
class JwtControllerTest extends AbstractHttpControllerTestCase
{
    Const REGEX_TOKEN = '/^[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+?\.([a-zA-Z0-9\-_]+)?$/';


    protected $mockedEm;
    protected $mockedUserRepository;
    protected $mockedUser;


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

        //Mock method getAuthenticateByEmailOrUsername on UserRepository
        $map = [
            ['userInvalid', null],
            ['userValid', $this->getMockUser()]
        ];
        $this->mockedUserRepository->method('getAuthenticateByEmailOrUsername')
            ->will($this->returnValueMap($map));

        //Mock method find on UserRepository
        $mapFind = [
            [null, null],
            [1, $this->getMockUser()]
        ];
        $this->mockedUserRepository->method('find')
            ->willReturn($this->getMockUser());
          //  ->will($this->returnValueMap($mapFind));

        return $this->mockedEm;
    }

    public function getMockUser()
    {
        if (!$this->mockedUser) {
            $this->mockedUser = new \ZfMetal\Security\Entity\User();
            $this->mockedUser->setId(1);
            $this->mockedUser->setUsername("userValid");
            $this->mockedUser->setActive(true);
            $bcrypt = new Bcrypt(['cost' => 12]);
            $password = $bcrypt->create("validPassword");
            $this->mockedUser->setPassword($password);
        }
        return $this->mockedUser;
    }

    /**
     * Verico que con metodo GET obtengo 404 not found
     */
    public function testAuthActionGet404notFound()
    {
        $this->dispatch("/auth", "GET");
        $this->assertResponseStatusCode(404);
    }



    /**
     * Verico que falta los parametros usuario y password
     */
    public function testAuthActionMissingParams()
    {
        $this->dispatch("/auth", "POST");


        $json = [
            'success' => false,
            'message' => "Missing Params. username and password required."
        ];

        $this->assertResponseStatusCode(422);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($json));
    }


    /**
     * Verico credenciales invalidas
     */
    public function testAuthActionInvalidCredentials()
    {
        $this->dispatch("/auth", "POST", ['username' => 'userInvalid', 'password' => 'invalidPassword']);


        $json = [
            'success' => false,
            'message' => "Invalid Credentials"
        ];

        $jsonResponse = $this->getResponse()->getContent();
        $this->assertResponseStatusCode(401);
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


        $this->assertEquals($jsonDecode->success, $json['success']);
        $this->assertEquals($jsonDecode->message, $json['message']);
        $this->assertRegExp(self::REGEX_TOKEN, $jsonDecode->token);

        return $jsonDecode->token;
    }


    /**
     * @depends testAuthActionValidCredentials
     * Obtengo la identidad haciendo una request con un token valido pre guardado
     * @param $token
     * @throws \Exception
     */
    public function testIdentityAction($token)
    {


        $headers = new Headers();
        $headers->addHeaderLine('Authorization', 'Bearer ' . $token);

        $this->getRequest()
            ->setMethod("get")
            ->setHeaders($headers);

        $this->dispatch("/my-identity");

        $json = [
            'id' => 1,
            'username' => 'userValid'
        ];

        $result = $this->getResponse()->getContent();
        var_dump($result);
        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString($result, json_encode($json));
    }
}
