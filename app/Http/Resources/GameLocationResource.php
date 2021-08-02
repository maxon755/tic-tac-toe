<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domain\Game\Game;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class GameLocationResource extends JsonResource
{
    private string $location;

    public function __construct(Game $game)
    {
        parent::__construct($game);

        static::$wrap = null;

        $this->location = route('game.get', [
            'id' => $game->getId(),
        ], false);
    }

    public function toArray($request)
    {
        return [
            'location' => $this->location
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Location', $this->location);
        $response->setStatusCode(Response::HTTP_CREATED);
    }
}
