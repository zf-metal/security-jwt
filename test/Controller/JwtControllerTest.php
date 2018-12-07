<?php
namespace Test\Controller;
use PHPUnit\Framework\TestCase;
use ZfMetal\SecurityJwt\Controller\JwtController;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
class JwtControllerTest extends AbstractHttpControllerTestCase
{
    protected $em;
    protected $jwtService;

    public function setUp(){
        $this->em = $this->createMock(\Doctrine\ORM\EntityManager::class);
        $options = new \ZfMetal\SecurityJwt\Options\ModuleOptions();
        $options->setSecretKey("123");
        $options->setEncrypt(['HS256']);
        $this->jwtService = new JwtService($options);
    }

        public function tearDown() {
            $this->http = null;
        }
    public function testCreateInstanfeOfJwtController(){
        $jwtController = new JwtController($this->getJwtService(),$this->getEm());
        $this->assertInstanceOf(JwtController::class, $jwtController);

        return $jwtController;
    }

    public function testIfGetIsNotAllowed()
    {
      //  $this->getRequest()->setMethod("GET");
      //  $this->dispatch(self::URL);
      //  $response = $this->getResponse();
      //  $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Get the value of Em
     *
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEm()
    {
        return $this->em;
    }

    /**
     * Get the value of Jwt Service
     *
     * @return ZfMetal\SecurityJwt\Service\JwtService
     */
    private function getJwtService()
    {
        return $this->jwtService;
    }

}
