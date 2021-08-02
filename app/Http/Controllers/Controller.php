<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    protected function message(string $message, int $status = 200, string $messageKey = 'message'): JsonResponse
    {
        return response()->json(
            [$messageKey => $message],
            $status
        );
    }

    protected function ok(string $message): JsonResponse
    {
        return $this->message($message, Response::HTTP_OK);
    }

    protected function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return $this->message($message, Response::HTTP_NOT_FOUND);
    }

    protected function badRequest(string $message): JsonResponse
    {
        return $this->message($message, Response::HTTP_BAD_REQUEST, 'reason');
    }
}
