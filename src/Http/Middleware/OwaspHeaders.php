<?php

namespace Chaman\Http\Middleware;

use Closure;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//  Laravel >= 5.2

/**
 *
 * USAGE
 * edit app/Kernel.php
 *
 * protected $middleware = [
 *   // https://laravel.com/docs/8.x/middleware#registering-middleware
 *   // note: there are two ways of registering a middleware
 *   \App\Http\Middleware\OwaspHeaders::class,
 * protected routeMiddleware = [
 *  'owasp.headers' => \App\Http\Middleware\OwaspHeaders::class,
 *
 * then
 * Route::get('/home', function () {
 *  //
 *  })->middleware('owasp.headers');
 */
class OwaspHeaders
{

    protected $addedHeaders;

    public function __construct(ConfigRepository $config)
    {
        $this->addedHeaders = $config->get('owasp-headers');
    }

    public function handle(Request $request, Closure $next)
    {
        /** @var Response extends Symfony\Component\HttpFoundation\Response */
        $response = $next($request);

        if ($request->ajax()) {
            return $response;
        }

        foreach ($this->addedHeaders as $key => $value) {
            $response->headers->set($key, $value, true);
        }

        return $response;
    }
}
