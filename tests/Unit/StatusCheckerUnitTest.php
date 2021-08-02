<?php

declare(strict_types=1);

namespace Unit;

use App\Domain\Board\Board;
use App\Domain\Board\StateValidator;
use App\Domain\Exceptions\WrongBoardSizeException;
use App\Domain\Exceptions\WrongMarksCountException;
use App\Domain\Exceptions\WrongSignException;
use App\Domain\Game\Status;
use App\Domain\Game\StatusChecker;
use App\Helpers\BoardStateConvertor;
use TestCase;

class StatusCheckerUnitTest extends TestCase
{
    private StatusChecker $statusChecker;

    public function setUp(): void
    {
        parent::setUp();

        $this->statusChecker = new StatusChecker();
    }

    /**
     * @test
     *
     * @dataProvider statusCheckDataProvider
     *
     * @throws WrongBoardSizeException
     * @throws WrongSignException
     * @throws WrongMarksCountException
     */
    public function game_status_check(string $boardState, Status $expectedStatus)
    {
        $this->assertEquals((string)$expectedStatus,
            $this->statusChecker->check(
                new Board(
                    new StateValidator(),
                    (new BoardStateConvertor)->fromStringToArray($boardState)
                )
            ));
    }

    public function statusCheckDataProvider(): array
    {
        return [
            // RUNNING
            [
                '-O--X----',
                Status::createRunningStatus()
            ],

            // DRAW
            [
                'XOXOXXOXO',
                Status::createDrawStatus()
            ],

            // X WON
            [
                'XXXOOXOO-',
                Status::createXWonStatus(),
            ],
            [
                'XO-XO-X--',
                Status::createXWonStatus(),
            ],

            [
                'XXXOOXOO-',
                Status::createXWonStatus(),
            ],
            [
                'XO-OX---X',
                Status::createXWonStatus(),
            ],

            // O WON
            [
                'OOOXX-X--',
                Status::createOWonStatus()
            ],
            [
                'OX-O-XO-X',
                Status::createOWonStatus()
            ],
            [
                'OX-O-XO-X',
                Status::createOWonStatus()
            ],
            [
                '--OXXOX-O',
                Status::createOWonStatus()
            ],
            [
                'X-OXOXO--',
                Status::createOWonStatus()
            ],
        ];
    }
}
