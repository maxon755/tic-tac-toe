<?php

namespace App\Domain\Board;

interface BoardInterface
{
    public function getState(): array;

    public function setMark(Mark $mark);
}
