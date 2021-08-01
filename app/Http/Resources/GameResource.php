<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Helpers\BoardStateConvertor;
use App\Domain\Game\Game;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    private BoardStateConvertor $boardStateConvertor;

    public function __construct($resource)
    {
        static::$wrap = null;
        parent::__construct($resource);

        $this->boardStateConvertor = new BoardStateConvertor();
    }

    public function toArray($request)
    {
        /** @var Game $game */
        $game = $this->resource;

        return [
            'id'       => $game->getId(),
            'board'    => $this->boardStateConvertor->fromArrayToString($game->getBoard()->getState()),
            'status'   => (string) $game->getStatus(),
        ];
    }
}
