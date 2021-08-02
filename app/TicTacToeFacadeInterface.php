<?php

declare(strict_types=1);

namespace App;

use App\Domain\Exceptions\CellIsNotEmptyException;
use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongMarkPositionException;
use App\Domain\Exceptions\WrongMarksCountException;
use App\Domain\Exceptions\WrongSignException;
use App\Domain\Game\Game;
use App\Exceptions\InconsistentBoardStateDiffException;

interface TicTacToeFacadeInterface
{
    /**
     * @param string $boardState
     *
     * @return Game
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     * @throws WrongMarksCountException
     */
    public function startGameWithStringBoardState(string $boardState): Game;

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
    public function makeNextHumanMove(Game $game, string $boardState): Game;
}
