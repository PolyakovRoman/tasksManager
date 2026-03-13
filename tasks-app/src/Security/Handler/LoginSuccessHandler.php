<?php
namespace App\Security\Handler;

use App\Shared\Traits\ApiResponseTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class LoginSuccessHandler extends AuthenticationSuccessHandler
{
    use ApiResponseTrait;

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        return $this->apiResponse(true, ['token' => $this->jwtManager->create($token->getUser())], [], JsonResponse::HTTP_OK);
    }
}