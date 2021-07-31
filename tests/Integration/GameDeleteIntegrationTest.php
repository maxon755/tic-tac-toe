<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Board\Board;
use App\Domain\Game\Game;

class GameDeleteIntegrationTest extends AbstractGameIntegrationTest
{
    /**
     * @test
     */
    public function delete_existing_game()
    {
        $game = new Game('uuid', new Board());

        $this->storage->store($game);

        $this->delete(route('game.delete', [
            'id' => $game->getId(),
        ]))
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function delete_non_existing_game()
    {
        $this->delete(route('game.delete', [
            'id' => 'some_id',
        ]))
            ->assertResponseStatus(404);
    }
}
