<?php

namespace App\Domain\Game;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;
use App\Domain\Bots\AbstractBot;
use App\Domain\Bots\SimpleBot;

class Game
{
    private Status $status;

    private StatusChecker $statusChecker;

    private AbstractBot $bot;

    private WhoIsNextChecker $whoIsNextChecker;

    public function __construct(
        private string $id,
        private Board  $board,
    )
    {
        $this->statusChecker = new StatusChecker();
        $this->whoIsNextChecker = new WhoIsNextChecker();

        $this->status = $this->statusChecker->check($this->board);

        $this->bot = new SimpleBot(Mark::O_SIGN);

        if (
            $this->status->isRunning() &&
            $this->whoIsNextChecker->check($this->board) === $this->bot->getSign()
        ) {
            $mark = $this->bot->makeMove($this->board);
            $this->board->setMark($mark);
        }
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

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }
}
