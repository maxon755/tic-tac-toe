<?php

declare(strict_types=1);

namespace App;

use App\Domain\Board\Board;
use App\Domain\Board\StateValidator;
use App\Domain\Exceptions\CellIsNotEmptyException;
use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongMarkPositionException;
use App\Domain\Exceptions\WrongMarksCountException;
use App\Domain\Exceptions\WrongSignException;
use App\Domain\Game\Game;
use App\Exceptions\InconsistentBoardStateDiffException;
use App\Helpers\BoardDiffFinder;
use App\Helpers\BoardStateConvertor;
use Ramsey\Uuid\Uuid;

class TicTacToeFacade implements TicTacToeFacadeInterface
{
    public function __construct(
        private BoardStateConvertor $boardStateConvertor,
        private BoardDiffFinder $boardDiffFinder
    ) {
    }

    /**
     * @param string $boardState
     *
     * @return Game
     * @throws CellIsNotEmptyException
     * @throws WrongMarkPositionException
     * @throws WrongBoardSizeException
     * @throws WrongMarksCountException
     * @throws WrongSignException
     */
    public function startGameWithStringBoardState(string $boardState): Game
    {
        $board = new Board(
            new StateValidator(),
            $this->boardStateConvertor->fromStringToArray($boardState)
        );

        return new Game(Uuid::uuid4()->toString(), $board);
    }

    /**
     * @param Game $game
     * @param string $boardState
     *
     * @return Game
     * @throws CellIsNotEmptyException
     * @throws WrongBoardSizeException
     * @throws WrongMarkPositionException
     * @throws WrongMarksCountException
     * @throws WrongSignException
     * @throws InconsistentBoardStateDiffException
     */
    public function makeNextHumanMove(Game $game, string $boardState): Game
    {
        $humanMoveMark = $this->boardDiffFinder->getDiff(
            $game->getBoard(),
            new Board(
                new StateValidator(),
                $this->boardStateConvertor->fromStringToArray($boardState)
            )
        );

        if ($humanMoveMark) {
            $game->makeHumanMove($humanMoveMark);
        }

        return $game;
    }
}
