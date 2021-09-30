<?php

namespace Tests\Chaman\Middleware;

use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Config\Repository as ConfigRepository;

use Chaman\Http\Middleware\OwaspHeaders;

// php vendor/bin/phpunit tests/Http/Middleware/OwaspHeadersTest.php
class OwaspHeadersTest extends TestCase
{

    public function testHeadersAreAdded()
    {
        $request = new Request;
        $config = $this->createMock(ConfigRepository::class);
        $config->expects($this->any())
            ->method('get')
            ->with('owasp-headers')
            ->will(
                $this->returnValue(
                    [
                        'x-header-a' => 'value for a',
                        'X-Content-Type-Option' => 'nosniff',
                        'Feature-Policy' => 'camera: \'none\'; payment: \'none\'; microphone: \'none\'',
                    ]
                )
            );

        $middleware = new OwaspHeaders($config);
        $response = $middleware->handle($request, function ($req) {
            return new Response();
        });

        $this->assertEquals(SymfonyResponse::HTTP_OK, $response->getStatusCode());

        /** @var ResponseHeaderBag $headers */
        $headers = $response->headers;
        $this->assertInstanceOf(ResponseHeaderBag::class, $headers);

        $this->assertIsArray($headers->all());
        $this->assertTrue($headers->has('x-header-a'));
        $this->assertFalse($headers->has('Content-Type'));
        $this->assertSame($headers->get('X-Content-Type-Option'), 'nosniff');
    }

}

