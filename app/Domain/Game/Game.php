<?php

namespace App\Domain\Game;

use App\Domain\Board\Board;

class Game
{
    private Status $status;

    private StatusChecker $statusChecker;

    public function __construct(
        private string $id,
        private Board  $board
    )
    {
        $this->statusChecker = new StatusChecker();

        $this->status = $this->statusChecker->check($this->board);
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
