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
            $this->checkVerticals($board, Mark::X_SIGN) ||
            $this->checkDiagonals($board, Mark::X_SIGN)
        ) {
            return Status::createXWonStatus();
        }

        if (
            $this->checkHorizontals($board, Mark::O_SIGN) ||
            $this->checkVerticals($board, Mark::O_SIGN) ||
            $this->checkDiagonals($board, Mark::O_SIGN)
        ) {
            return Status::createOWonStatus();
        }

        if ($this->isBoardFull($board)) {
            return Status::createDrawStatus();
        }

        return Status::createRunningStatus();
    }

    private function isBoardFull(Board $board): bool
    {
        foreach ($board->getState() as $row) {
            foreach ($row as $cell) {
                if ($cell === Board::EMPTY_CELL_SIGN) {
                    return false;
                }
            }
        }

        return true;
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

    private function checkDiagonals(Board $board, string $sign): bool
    {
        $primaryDiagonalSings = [];

        for ($i = 0; $i < Board::BOARD_SIZE; $i++) {
            for ($j = 0; $j < Board::BOARD_SIZE; $j++) {
                if ($i === $j) {
                    $primaryDiagonalSings[] = $board->getState()[$i][$j];
                }
            }
        }

        $secondaryDiagonalSigns = [];

        for ($i = 0; $i < Board::BOARD_SIZE; $i++) {
            for ($j = 0; $j < Board::BOARD_SIZE; $j++) {
                if ($i + $j === Board::BOARD_SIZE - 1) {
                    $secondaryDiagonalSigns[] = $board->getState()[$i][$j];
                }
            }
        }

        return $this->checkArrayElementsEquals($primaryDiagonalSings, $sign) ||
            $this->checkArrayElementsEquals($secondaryDiagonalSigns, $sign);

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
