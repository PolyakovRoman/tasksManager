<?php
namespace App\Shared\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiResponseTrait
{
    public function apiResponse(bool $success = false, $data = null, array $errors = [], int $code = 200): JsonResponse
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