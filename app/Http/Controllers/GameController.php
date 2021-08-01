<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\BoardStateConvertor;
use App\Domain\Board\Board;
use App\Domain\Game\Game;
use App\Http\Resources\GameLocationResource;
use App\Http\Resources\GameResource;
use App\Storages\GameStorage\GameStorage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class GameController extends Controller
{
    public function __construct(private GameStorage $gameStorage)
    {
    }

    public function create(Request $request): GameLocationResource
    {
        $this->validate($request, [
            'board' => 'required|string|size:9'
        ]);

        $boardState = $request->input('board');

        $board = new Board(BoardStateConvertor::fromStringToArray($boardState));

        $game = new Game(Uuid::uuid4()->toString(), $board);

        $this->gameStorage->store($game);

        return GameLocationResource::make($game);
    }

    public function get(string $id): JsonResponse | GameResource
    {
        $game = $this->gameStorage->get($id);

        if (!$game) {
            return $this->notFound();
        }

        return GameResource::make($game);
    }

    public function delete(string $id): JsonResponse
    {
        if (!$this->gameStorage->has($id)) {
            return $this->notFound();
        }

        if ($this->gameStorage->delete($id)) {
            return $this->ok('Game successfully deleted');
        } else {
            throw new Exception('Something going wrong while game deletion');
        }
    }

    public function index()
    {
        $games = $this->gameStorage->getAll();

        return GameResource::collection($games);
    }
}
