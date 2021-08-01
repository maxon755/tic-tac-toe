<?php

declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongSignException;

class StateValidator
{
    /**
     * @param array $state
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     */
    public function validate(array $state): void
    {
        $this->validateSize($state);
        $this->validateSigns($state);
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
}
