<?php

namespace App\Shared\Domain\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiResponseTrait
{
    public function apiResponse(bool $success = false, $data = [], array $errors = [], int $code = JsonResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => $success ? 'success' : 'error',
                'result' => $data,
                'errors' => $errors
            ],
            $code
        );
    }
}