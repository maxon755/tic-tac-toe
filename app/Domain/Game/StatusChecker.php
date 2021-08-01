<?php

declare(strict_types=1);

namespace App\Domain\Game;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;

class StatusChecker
{
    /**
     * Check board state to determine game status
     *
     * @param Board $board
     *
     * @return Status
     */
    public function check(Board $board): Status
    {
        if (
            $this->checkHorizontals($board, Mark::X_SIGN) ||
            $this->checkVerticals($board, Mark::X_SIGN)
        ) {
            return Status::createXWonStatus();
        }

        return Status::createRunningStatus();
    }

    private function checkHorizontals(Board $board, string $sign): bool
    {
        $signWon = false;

        foreach ($board->getState() as $row) {
            $signWon = $this->checkArrayElementsEquals($row, $sign);

            if ($signWon === true) {
                break;
            }
        }

        return $signWon;
    }

    private function checkVerticals(Board $board, string $sign): bool
    {
        $signWon = false;

        foreach ($this->transpose($board->getState()) as $column) {
            $signWon = $this->checkArrayElementsEquals($column, $sign);

            if ($signWon === true) {
                break;
            }
        }

        return $signWon;
    }

    function transpose($array)
    {
        array_unshift($array, null);
        return call_user_func_array('array_map', $array);
    }

    private function checkArrayElementsEquals(array $array, string $sign): bool
    {
        $unique = array_unique($array);

        $theOnlySign = count($unique) === 1;
        $signEquals = array_shift($unique) === $sign;

        return $theOnlySign && $signEquals;
    }
}
