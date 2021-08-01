<?php

namespace App\Domain\Bots;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;

interface BotInterface
{
    public function makeMove(Board $board): Mark;
}
