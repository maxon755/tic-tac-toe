<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\GameLocationResource;
use App\Http\Resources\GameResource;
use App\Storages\GameStorage\GameStorage;
use App\TicTacToeFacadeInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(private GameStorage $gameStorage)
    {
    }

    public function create(Request $request, TicTacToeFacadeInterface $ticTacToeFacade): GameLocationResource
    {
        $this->validate($request, [
            'board' => 'required|string|size:9'
        ]);

        $boardState = $request->input('board');

        $game = $ticTacToeFacade->startGameWithStringBoardState($boardState);

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
