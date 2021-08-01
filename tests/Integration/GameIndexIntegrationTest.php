<?php

declare(strict_types=1);

namespace Integration;

class GameIndexIntegrationTest extends AbstractGameIntegrationTest
{
    /**
     * @test
     */
    public function get_all_games()
    {
        $gamesCount = 5;

        foreach (range(0, $gamesCount - 1) as $index) {
            $this->createGame();
        }

        $this->get(route('game.index'))
            ->seeJsonStructure(array_fill(0, $gamesCount, [
                'id',
                'board',
                'status',
            ]))
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function get_all_games_when_no_games()
    {
        $this->get(route('game.index'))
            ->seeJsonStructure([])
            ->assertResponseOk();
    }
}
