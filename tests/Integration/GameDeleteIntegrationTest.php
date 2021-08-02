<?php

declare(strict_types=1);

namespace Integration;

class GameDeleteIntegrationTest extends AbstractGameIntegrationTest
{
    /**
     * @test
     */
    public function delete_existing_game()
    {
        $game = $this->createGame();

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
