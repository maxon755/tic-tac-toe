<?php

declare(strict_types=1);

namespace App;

use App\Domain\Game\Game;

interface TicTacToeFacadeInterface
{
    /**
     * @param string $boardState
     *
     * @return Game
     * @throws Domain\Exceptions\WrongBoardSizeException
     * @throws Domain\Exceptions\WrongSignException
     */
    public function startGameWithStringBoardState(string $boardState): Game;
}
