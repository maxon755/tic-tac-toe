<?php

declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongSignException;

class Board implements BoardInterface
{
    private array $state;

    public const BOARD_SIZE = 3;

    public const EMPTY_CELL_SIGN = '-';

    /**
     * @param array|null $state
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     */
    public function __construct(?array $state = null)
    {
        if ($state) {
            (new StateValidator())->validate($state);
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
     */
    public function setMark(Mark $mark)
    {
        $this->state[$mark->getRow()][$mark->getColumn()] = $mark->getSign();
    }
}
