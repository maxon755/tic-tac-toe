<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    protected function message(string $message, int $status = 200): JsonResponse
    {
        return response()->json(
            ['message' => $message],
            $status
        );
    }

    protected function unprocessableEntity(string $message): JsonResponse
    {
        return $this->message($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function notFound(string $message): JsonResponse
    {
        return $this->message($message, Response::HTTP_NOT_FOUND);
    }
}
