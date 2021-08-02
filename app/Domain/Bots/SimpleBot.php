<?php

namespace App\Domain\Bots;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;

class SimpleBot extends AbstractBot
{

    public function makeMove(Board $board): ?Mark
    {
        foreach ($board->getState() as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($cell === Board::EMPTY_CELL_SIGN) {
                    return new Mark($i, $j, $this->getSign());
                }
            }
        }

        return null;
    }
}
