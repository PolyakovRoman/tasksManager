<?php
namespace App\Security\Handler;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTNotFoundHandler
{
    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $response = new JsonResponse(
            [
                'status' => 'error',
                'result' => [],
                'errors' => ['Forbidden']
            ],
            JsonResponse::HTTP_FORBIDDEN
        );

        $event->setResponse($response);
    }
}