<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Domain\Board\Board;

class BoardStateConvertor
{
    public function fromStringToArray(string $boardState): array
    {
        $boardState = str_split($boardState);
        $boardState = array_chunk($boardState, Board::BOARD_SIZE);

        return $boardState;
    }

    public function fromArrayToString(array $boardState): string
    {
        $boardStateString = '';

        foreach ($boardState as $row) {
            $boardStateString .= implode('', $row);
        }

        return $boardStateString;
    }
}
