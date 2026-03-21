<?php

namespace App\User\Security\Handler;

use App\Shared\Domain\Traits\ApiResponseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTNotFoundHandler
{
    use ApiResponseTrait;

    public function onJWTNotFound(JWTNotFoundEvent $event): JsonResponse
    {

        return $this->apiResponse(false, [], ['Forbidden'], JsonResponse::HTTP_FORBIDDEN);
    }
}