<?php

declare(strict_types=1);

namespace App\Domain\Game;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;

class WhoIsNextChecker
{
    public function check(Board $board): string
    {
        $xMarks = $this->countSign($board, Mark::X_SIGN);
        $oMarks = $this->countSign($board, Mark::O_SIGN);

        return $xMarks === $oMarks ? Mark::X_SIGN : Mark::O_SIGN;
    }

    private function countSign(Board $board, string $sign): int
    {
        $counter = 0;

        foreach ($board->getState() as $row) {
            foreach ($row as $cell) {
                if ($cell === $sign) {
                    $counter++;
                }
            }
        }

        return $counter;
    }
}
