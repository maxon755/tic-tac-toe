<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Game\Status;
use App\Helpers\BoardStateConvertor;

class GameGetIntegrationTest extends AbstractGameIntegrationTest
{
    /**
     * @test
     */
    public function get_existing_game()
    {
        $game = $this->createGame();

        $this->get(route('game.get', [
            'id' => $game->getId(),
        ]))
            ->seeJson([
                'id'     => $game->getId(),
                'board'  => (new BoardStateConvertor())->fromArrayToString($game->getBoard()->getState()),
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
