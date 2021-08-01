<?php

declare(strict_types=1);

namespace Unit;

use App\Domain\Board\Board;
use App\Domain\Board\Mark;
use App\Domain\Board\StateValidator;
use App\Domain\Exceptions\CellIsNotEmptyException;
use App\Domain\Exceptions\WrongMarkPositionException;
use App\Domain\Exceptions\WrongSignException;
use App\Domain\Game\WhoIsNextChecker;
use TestCase;

class WhoIsNextCheckerUnitTest extends TestCase
{
    private WhoIsNextChecker $whoIsNextChecker;

    public function setUp(): void
    {
        parent::setUp();

        $this->whoIsNextChecker = new WhoIsNextChecker();
    }

    private function createEmptyBoard(): Board
    {
        return new Board(new StateValidator(), array_fill(
            0,
            Board::BOARD_SIZE,
            array_fill(
                0,
                Board::BOARD_SIZE,
                Board::EMPTY_CELL_SIGN,
            )
        ));
    }

    /**
     * @test
     *
     * @throws WrongMarkPositionException
     * @throws WrongSignException
     */
    public function o_next_test()
    {
        $board = $this->createEmptyBoard();

        $board->setMark(Mark::createXMark(0, 0));

        $this->assertEquals(Mark::O_SIGN, $this->whoIsNextChecker->check($board));
    }

    /**
     * @test
     *
     * @throws WrongMarkPositionException
     * @throws WrongSignException
     * @throws CellIsNotEmptyException
     */
    public function x_next_test()
    {
        $board = $this->createEmptyBoard();

        $board->setMark(Mark::createXMark(0, 0));
        $board->setMark(Mark::createOMark(0, 1));

        $this->assertEquals(Mark::X_SIGN, $this->whoIsNextChecker->check($board));
    }
}
