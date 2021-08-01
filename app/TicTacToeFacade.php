<?php

declare(strict_types=1);

namespace App;

use App\Domain\Board\Board;
use App\Domain\Board\StateValidator;
use App\Domain\Game\Game;
use App\Helpers\BoardStateConvertor;
use Ramsey\Uuid\Uuid;

class TicTacToeFacade implements TicTacToeFacadeInterface
{
    public function __construct(private BoardStateConvertor $boardStateConvertor)
    {
    }

    /**
     * @param string $boardState
     *
     * @return Game
     * @throws Domain\Exceptions\WrongBoardSizeException
     * @throws Domain\Exceptions\WrongSignException
     */
    public function startGameWithStringBoardState(string $boardState): Game
    {
        $board = new Board(
            new StateValidator(),
            $this->boardStateConvertor->fromStringToArray($boardState)
        );

        $game = new Game(Uuid::uuid4()->toString(), $board);

        return $game;
    }
}
