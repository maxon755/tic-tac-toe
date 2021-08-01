<?php

declare(strict_types=1);

namespace Unit;

use App\Domain\Board\Board;
use App\Domain\Board\StateValidator;
use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongMarksCountException;
use App\Domain\Exceptions\WrongSignException;
use TestCase;

class StateValidatorUnitTest extends TestCase
{
    private StateValidator $stateValidator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stateValidator = new StateValidator();
    }

    private function createEmptyBoardState(
        int $rows = Board::BOARD_SIZE,
        int $columns = Board::BOARD_SIZE,
    ): array
    {
        return array_fill(
            0,
            $rows,
            array_fill(
                0,
                $columns,
                Board::EMPTY_CELL_SIGN,
            )
        );
    }

    /**
     * @test
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     */
    public function wrong_board_rows_count()
    {
        $this->expectException(WrongBoardSizeException::class);

        $this->stateValidator->validate(
            $this->createEmptyBoardState(Board::BOARD_SIZE + 1)
        );

        $this->expectException(WrongBoardSizeException::class);
    }

    /**
     * @test
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     */
    public function wrong_board_columns_count()
    {
        $this->expectException(WrongBoardSizeException::class);

        $this->stateValidator->validate(
            $this->createEmptyBoardState(columns: Board::BOARD_SIZE + 1)
        );

    }

    /**
     * @test
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     */
    public function wrong_sign()
    {
        $this->expectException(WrongSignException::class);

        $board = $this->createEmptyBoardState();

        $board[0][0] = 'Z';

        $this->stateValidator->validate($board);
    }

    /**
     * @test
     *
     * @skip
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     */
    public function wrong_marks_count()
    {
        $this->expectException(WrongMarksCountException::class);

        $board = $this->createEmptyBoardState();

        $board[0][0] = 'X';
        $board[0][1] = 'X';

        $this->stateValidator->validate($board);
    }
}
