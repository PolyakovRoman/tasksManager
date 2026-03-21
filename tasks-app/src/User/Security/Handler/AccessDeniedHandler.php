<?php

namespace App\User\Security\Handler;

use App\Shared\Domain\Traits\ApiResponseTrait;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    use ApiResponseTrait;

    public function handle(Request $request, AccessDeniedException $exception): JsonResponse
    {
        return $this->apiResponse(false, [], ['Access Denied.'], JsonResponse::HTTP_FORBIDDEN);
    }
}