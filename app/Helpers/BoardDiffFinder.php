<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;
use App\Domain\Exceptions\WrongSignException;
use App\Exceptions\InconsistentBoardStateDiffException;

class BoardDiffFinder
{
    public function __construct()
    {
    }

    /**
     * @param Board $originalBoard
     * @param Board $newBoard
     *
     * @return Mark|null
     * @throws InconsistentBoardStateDiffException
     * @throws WrongSignException
     */
    public function getDiff(Board $originalBoard, Board $newBoard): ?Mark
    {
        $firstDiff = null;
        $diffCount = 0;

        for ($i = 0; $i < Board::BOARD_SIZE; $i++) {
            for ($j = 0; $j < Board::BOARD_SIZE; $j++) {
                if ($originalBoard->getState()[$i][$j] !== $newBoard->getState()[$i][$j]) {
                    if (empty($firstDiff)) {
                        $firstDiff = new Mark($i, $j, $newBoard->getState()[$i][$j]);
                    }

                    $diffCount++;
                }
            }
        }

        if ($diffCount > 1) {
            throw new InconsistentBoardStateDiffException();
        }

        return $firstDiff;
    }
}
