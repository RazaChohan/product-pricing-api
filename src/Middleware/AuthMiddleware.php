<?php

declare(strict_types=1);

namespace App\Middleware;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ApiKeyMiddleware implements HttpKernelInterface
{
    private const string API_KEY = 'secure-key-123';

    public function __construct(
        private readonly HttpKernelInterface $app,
        private readonly Logger $logger
    ) {
    }

    public function handle(
        Request $request,
        int $type = HttpKernelInterface::MAIN_REQUEST,
        ?bool $catch = true
    ): \Symfony\Component\HttpFoundation\Response {
        $apiKey = $request->headers->get('X-API-Key');
        if ($apiKey !== self::API_KEY) {
            $this->logger->warning('Unauthorized API access attempt');
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        return $this->app->handle($request, $type, $catch);
    }
}
