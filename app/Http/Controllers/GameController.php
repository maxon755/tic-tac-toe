<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Exceptions\BoardStateException;
use App\Http\Resources\GameLocationResource;
use App\Http\Resources\GameResource;
use App\Storages\GameStorage\GameStorage;
use App\TicTacToeFacadeInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class GameController extends Controller
{
    public function __construct(private GameStorage $gameStorage)
    {
    }

    /**
     * @param Request $request
     * @param TicTacToeFacadeInterface $ticTacToeFacade
     *
     * @return JsonResponse|GameLocationResource
     */
    public function create(
        Request $request,
        TicTacToeFacadeInterface $ticTacToeFacade
    ): JsonResponse|GameLocationResource {
        try {
            $this->validate($request, ['board' => 'required|string|size:9']);
        } catch (ValidationException $exception) {
            return $this->badRequest($exception->getMessage());
        }

        $boardState = $request->input('board');

        try {
            $game = $ticTacToeFacade->startGameWithStringBoardState($boardState);
        } catch (BoardStateException $exception) {
            return $this->badRequest($exception->getMessage());
        }

        $this->gameStorage->store($game);

        return GameLocationResource::make($game);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse|GameResource
     */
    public function get(string $id): JsonResponse | GameResource
    {
        $game = $this->gameStorage->get($id);

        if (!$game) {
            return $this->notFound();
        }

        return GameResource::make($game);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     * @throws Exception
     */
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

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $games = $this->gameStorage->getAll();

        return GameResource::collection($games);
    }
}
