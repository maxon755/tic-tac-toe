<?php

declare(strict_types=1);

namespace App\Domain\Game;

class Status
{
    public const RUNNING = 'RUNNING';
    public const X_WON = 'X_WON';
    public const O_WON = 'O_WON';
    public const DRAW = 'DRAW';

    private function __construct(private string $status)
    {
    }

    public static function createRunningStatus(): self
    {
        return new self(self::RUNNING);
    }

    public static function createXWonStatus(): self
    {
        return new self(self::X_WON);
    }

    public static function createOWonStatus(): self
    {
        return new self(self::O_WON);
    }

    public static function createDrawStatus():self
    {
        return new self(self::DRAW);
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
