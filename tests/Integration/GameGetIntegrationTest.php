<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Board\Board;
use App\Domain\Game\Game;
use App\Domain\Game\Status;
use App\Storages\GameStorage\GameStorage;
use TestCase;

class GameGetIntegrationTest extends TestCase
{
    /**
     * @var GameStorage
     */
    private GameStorage $storage;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var GameStorage storage */
        $this->storage = resolve(GameStorage::class);
    }

    private function getGameResource(): array
    {
        return [
            'id',
            'board',
            'status',
        ];
    }

    /**
     * @test
     */
    public function get_existing_game()
    {
        $game = new Game('uuid', new Board());

        $this->storage->store($game);

        $this->get(route('game.get', [
            'id' => $game->getId(),
        ]))
            ->seeJson([
                'id'     => 'uuid',
                'board'  => '---------',
                'status' => Status::RUNNING,
            ])
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function get_non_existing_game()
    {

        $this->get(route('game.get', [
            'id' => 'some_id',
        ]))
            ->assertResponseStatus(404);
    }
}
