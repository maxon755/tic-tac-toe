<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Board\Board;
use App\Domain\Board\StateValidator;
use App\Domain\Game\Game;
use App\Helpers\BoardStateConvertor;
use App\Storages\GameStorage\GameStorage;
use Ramsey\Uuid\Uuid;
use TestCase;

abstract class AbstractGameIntegrationTest extends TestCase
{
    /**
     * @var GameStorage
     */
    protected GameStorage $storage;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var GameStorage storage */
        $this->storage = resolve(GameStorage::class);
    }

    protected function createGame(?string $boardState = null): Game
    {
        if ($boardState) {
            $boardState = (new BoardStateConvertor())->fromStringToArray($boardState);
        }

        $game = new Game(Uuid::uuid4()->toString(), new Board(new StateValidator(), $boardState));

        $this->storage->store($game);

        return $game;
    }
}
