<?php

namespace App\User\Security\Handler;

use App\Shared\Domain\Traits\ApiResponseTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class LoginSuccessHandler extends AuthenticationSuccessHandler
{
    use ApiResponseTrait;

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        return $this->apiResponse(true, ['token' => $this->jwtManager->create($token->getUser())], []);
    }
}