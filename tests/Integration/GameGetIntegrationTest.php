<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Board\Board;
use App\Domain\Board\StateValidator;
use App\Domain\Game\Game;
use App\Domain\Game\Status;

class GameGetIntegrationTest extends AbstractGameIntegrationTest
{
    /**
     * @test
     */
    public function get_existing_game()
    {
        $game = new Game('uuid', new Board(new StateValidator()));

        $this->storage->store($game);

        $this->get(route('game.get', [
            'id' => $game->getId(),
        ]))
            ->seeJson([
                'id'     => 'uuid',
                'board'  => '---------',
                'status' => (string) Status::createRunningStatus(),
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
