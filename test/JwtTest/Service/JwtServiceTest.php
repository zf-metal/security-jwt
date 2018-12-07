<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Jwt\Service\JwtService;

class JwtServiceTest extends TestCase
{

    private $service;
    Const REGEX_TOKEN = '/^[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+?\.([a-zA-Z0-9\-_]+)?$/';

    public function setUp()
    {
        $options = new \ZfMetal\SecurityJwt\Options\ModuleOptions();
        $options->setSecretKey("123");
        $options->setEncrypt(['HS256']);
        $this->service = new JwtService($options);
    }

    private function getService()
    {
        return $this->service;
    }

    public function testInstanceOfJwtService()
    {
        $this->assertInstanceOf(JwtService::class, $this->getService());
    }

    public function testGetToken()
    {
        $data = ['test'];
        $token = $this->getService()->signIn($data);

        $this->assertRegExp(self::REGEX_TOKEN, $token);

        return $token;
    }

    /**
     * @depends testGetToken
     **/
    public function testCheckValidToken($token)
    {
        $this->assertTrue($this->getService()->checkToken($token));
    }

    /**
     * @depends testGetToken
     * @expectedException Jwt\Exception\InvalidTokenSuppledException
     **/
    public function testCheckMethodWhenEmptyReturnAnError($token)
    {
        $this->assertTrue($this->getService()->checkToken());
    }

    /**
     * @depends testGetToken
     * @expectedException Jwt\Exception\InvalidUserLoggedInExcetion
     **/
    public function testCheckMethodWhenInvalidUserLoggedInReturnAnError($token)
    {
        $this->assertTrue($this->getService()->changeAud()->checkToken($token));
    }

    /**
     * @depends testGetToken
     **/
    public function testGetDataToken($token)
    {
        $expectData = ['test'];

        $actualData = $this->getService()->getData($token);

        $this->assertJsonStringEqualsJsonString(
            json_encode($expectData),
            json_encode($actualData)
        );
    }

}
