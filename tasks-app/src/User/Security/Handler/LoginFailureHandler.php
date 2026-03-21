<?php

namespace App\User\Security\Handler;

use App\Shared\Domain\Traits\ApiResponseTrait;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;

class LoginFailureHandler extends AuthenticationFailureHandler
{
    use ApiResponseTrait;

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return $this->apiResponse(false, [], [$exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
    }
}