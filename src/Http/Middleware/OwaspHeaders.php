<?php

declare(strict_types=1);

namespace Chaman\Http\Middleware;

use Closure;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwaspHeaders
{
    /**
     * @var array
     */
    protected array $addedHeaders = [];

    /**
     * @param ConfigRepository $config
     */
    public function __construct(ConfigRepository $config)
    {
        $this->addedHeaders = $config->get('owasp-headers', []);
    }

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response */
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
