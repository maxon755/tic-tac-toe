<?php

namespace App\Domain\Game;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;
use App\Domain\Bots\AbstractBot;
use App\Domain\Bots\SimpleBot;
use App\Domain\Exceptions\CellIsNotEmptyException;
use App\Domain\Exceptions\WrongMarkPositionException;

class Game
{
    public const HUMAN_SIGN = Mark::X_SIGN;

    public const BOT_SIGN = Mark::O_SIGN;

    private Status $status;

    private StatusChecker $statusChecker;

    private AbstractBot $bot;

    private WhoIsNextChecker $whoIsNextChecker;

    /**
     * @param string $id
     * @param Board $board
     *
     * @throws CellIsNotEmptyException
     * @throws WrongMarkPositionException
     */
    public function __construct(
        private string $id,
        private Board  $board,
    )
    {
        $this->statusChecker = new StatusChecker();
        $this->whoIsNextChecker = new WhoIsNextChecker();

        $this->checkGameStatus();

        $this->bot = new SimpleBot(self::BOT_SIGN);

        if ($this->status->isRunning() && $this->botIsNext()) {
            $this->makeBotMove();
        }
    }

    private function botIsNext(): bool
    {
        return $this->whoIsNextChecker->check($this->board) === $this->bot->getSign();
    }

    private function checkGameStatus(): void
    {
        $this->status = $this->statusChecker->check($this->board);
    }

    /**
     * @param Mark $humanMoveMark
     *
     * @throws CellIsNotEmptyException
     * @throws WrongMarkPositionException
     */
    public function makeHumanMove(Mark $humanMoveMark): void
    {
        if (!$this->status->isRunning() || $humanMoveMark->getSign() !== self::HUMAN_SIGN) {
            return;
        }

        $this->board->setMark($humanMoveMark);
        $this->checkGameStatus();

        if ($this->status->isRunning()) {
            $this->makeBotMove();
        }
    }

    /**
     * @throws CellIsNotEmptyException
     * @throws WrongMarkPositionException
     */
    private function makeBotMove()
    {
        $mark = $this->bot->makeMove($this->board);
        $this->board->setMark($mark);
        $this->checkGameStatus();
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
