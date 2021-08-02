<?php

declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongMarksCountException;
use App\Domain\Exceptions\WrongSignException;

class StateValidator
{
    /**
     * @param array $state
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     * @throws WrongMarksCountException
     */
    public function validate(array $state): void
    {
        $this->validateSize($state);
        $this->validateSigns($state);
        $this->validateSingsCount($state);
    }

    /**
     * @param array $state
     *
     * @throws WrongBoardSizeException
     */
    private function validateSize(array $state): void
    {
        if (count($state) !== Board::BOARD_SIZE) {
            throw new WrongBoardSizeException();
        }

        foreach ($state as $row) {
            if (count($row) !== Board::BOARD_SIZE) {
                throw new WrongBoardSizeException();
            }
        }
    }

    /**
     * @param array $state
     *
     * @throws WrongSignException
     */
    private function validateSigns(array $state): void
    {
        foreach ($state as $row) {
            foreach ($row as $column) {
                if ($column !== Board::EMPTY_CELL_SIGN && !Mark::isSignValid($column)) {
                    throw new WrongSignException($column);
                }
            }
        }
    }

    /**
     * @param array $state
     *
     * @throws WrongMarksCountException
     */
    private function validateSingsCount(array $state): void
    {
        $xMarks = $this->countSign($state, Mark::X_SIGN);
        $oMarks = $this->countSign($state, Mark::O_SIGN);

        if ($xMarks - $oMarks < 0 || $xMarks - $oMarks > 1) {
            throw new WrongMarksCountException();
        }
    }

    private function countSign(array $state, string $sign): int
    {
        $counter = 0;

        foreach ($state as $row) {
            foreach ($row as $cell) {
                if ($cell === $sign) {
                    $counter++;
                }
            }
        }

        return $counter;
    }
}
