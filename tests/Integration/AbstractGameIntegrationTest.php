<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Board\Board;
use App\Domain\Board\StateValidator;
use App\Domain\Game\Game;
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

    protected function createGame()
    {
        $game = new Game(Uuid::uuid4()->toString(), new Board(new StateValidator()));
        $this->storage->store($game);
    }
}
