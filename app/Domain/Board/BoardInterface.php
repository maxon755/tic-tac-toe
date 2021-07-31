<?php

namespace App\Domain\Board;

interface BoardInterface
{
    public const BOARD_SIZE = 3;

    public const EMPTY_CELL_SIGN = '-';

    public function getState(): array;

    public function setMark(Mark $mark);
}
