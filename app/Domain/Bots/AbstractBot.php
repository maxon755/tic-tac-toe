<?php

declare(strict_types=1);

namespace App\Domain\Bots;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;

abstract class AbstractBot
{
    public function __construct(protected string $sign)
    {
    }

    /**
     * @return string
     */
    public function getSign(): string
    {
        return $this->sign;
    }

    public abstract function makeMove(Board $board): Mark;
}
