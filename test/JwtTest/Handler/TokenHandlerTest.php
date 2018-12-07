<?php

declare(strict_types=1);

namespace JwtTest\Handler;

use App\Handler\PingHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Jwt\Service\JwtService;
use Jwt\Handler\TokenHandler;

class TokenHandlerTest extends TestCase
{
    public function testResponse()
    {
        $jwtService   = new JwtService();
        $tokenHandler = new TokenHandler($jwtService);
        $response     = $tokenHandler->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $json = json_decode((string) $response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertTrue(isset($json->access_token));
    }
}
