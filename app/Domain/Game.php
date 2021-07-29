<?php

namespace App\Domain;

use App\Domain\Board\Board;

class Game
{
    public function __construct(
        private string $id,
        private Board $board
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }
}
