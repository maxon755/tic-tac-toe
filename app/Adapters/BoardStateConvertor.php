<?php
declare(strict_types=1);

namespace App\Adapters;

use App\Domain\Board\BoardInterface;

class BoardStateConvertor
{
    public static function fromStringToArray(string $boardState): array
    {
        $boardState = str_split($boardState);
        $boardState = array_chunk($boardState, BoardInterface::BOARD_SIZE);

        return $boardState;
    }

    public static function fromArrayToString(array $boardState): string
    {
        $boardStateString = '';

        foreach ($boardState as $row) {
            $boardStateString .= implode('', $row);
        }

        return $boardStateString;
    }
}
