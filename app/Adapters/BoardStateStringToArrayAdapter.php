<?php
declare(strict_types=1);

namespace App\Adapters;

class BoardStateStringToArrayAdapter
{
    public static function adapt(string $boardState): array
    {
        $boardState = str_split($boardState);
        $boardState = array_chunk($boardState, 3);

        return $boardState;
    }
}
