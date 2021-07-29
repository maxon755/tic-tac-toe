<?php

namespace App\Domain\Bots;

use App\Domain\Board\BoardInterface;
use App\Domain\Board\Mark;

interface BotInterface
{
    public function makeMove(BoardInterface $board): Mark;
}
