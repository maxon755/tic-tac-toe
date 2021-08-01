<?php

declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\Exceptions\CellIsNotEmptyException;
use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongMarkPositionException;
use App\Domain\Exceptions\WrongSignException;

class Board
{
    public const BOARD_SIZE = 3;

    public const EMPTY_CELL_SIGN = '-';

    private array $state;

    /**
     * @param array|null $state
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     */
    public function __construct(StateValidator $stateValidator, ?array $state = null)
    {
        if ($state) {
            $stateValidator->validate($state);
        }

        $this->state = $state ?? $this->createEmptyBoard();
    }

    private function createEmptyBoard(): array
    {
        return array_fill(
            0,
            self::BOARD_SIZE,
            array_fill(
                0,
                self::BOARD_SIZE,
                self::EMPTY_CELL_SIGN,
            )
        );
    }

    public function getState(): array
    {
        return $this->state;
    }

    /**
     * @param Mark $mark
     *
     * @throws WrongMarkPositionException
     * @throws CellIsNotEmptyException
     */
    public function setMark(Mark $mark)
    {
        $this->checkMarkPosition($mark);
        $this->checkCellAvailability($mark);

        $this->state[$mark->getRow()][$mark->getColumn()] = $mark->getSign();
    }

    /**
     * @param Mark $mark
     *
     * @throws WrongMarkPositionException
     */
    private function checkMarkPosition(Mark $mark)
    {
        $row = $mark->getRow();
        $column = $mark->getColumn();

        if ($row < 0 && $row >= self::BOARD_SIZE) {
            throw new WrongMarkPositionException($row, $column);
        }

        if ($column < 0 && $column >= self::BOARD_SIZE) {
            throw new WrongMarkPositionException($row, $column);
        }
    }

    /**
     * @param Mark $mark
     *
     * @throws CellIsNotEmptyException
     */
    private function checkCellAvailability(Mark $mark): void
    {
        if ($this->state[$mark->getRow()][$mark->getColumn()] !== self::EMPTY_CELL_SIGN) {
            throw new CellIsNotEmptyException($mark->getRow(), $mark->getColumn());
        }
    }
}
