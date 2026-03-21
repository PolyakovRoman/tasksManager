<?php

namespace App\Shared\Domain\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait ApiRequestTrait
{
    private function decodeJson(Request $request): array
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (DefaultException $e) {
            throw new DefaultException(['Invalid JSON'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!is_array($data)) {
            throw new DefaultException(['JSON body must be an object'], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $data;
    }
}