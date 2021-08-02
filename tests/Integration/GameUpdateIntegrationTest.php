<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Game\Status;

class GameUpdateIntegrationTest extends AbstractGameIntegrationTest
{
    /**
     * @test
     */
    public function game_can_be_updated()
    {
        $game = $this->createGame();

        $this
            ->put(route('game.update', [
                'id' => $game->getId(),
                'board' => '----X----',
            ]))
            ->seeJson([
                'status' => (string) Status::createRunningStatus()
            ])
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function game_can_be_updated_for_x_win()
    {
        $game = $this->createGame('OXO-X----');

        $this
            ->put(route('game.update', [
                'id' => $game->getId(),
                'board' => 'OXO-X--X-',
            ]))
            ->seeJson([
                'status' => (string) Status::createXWonStatus()
            ])
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function game_can_be_updated_for_o_win()
    {
        $game = $this->createGame('OO--X---X');

        $this
            ->put(route('game.update', [
                'id' => $game->getId(),
                'board' => 'OO-XX---X',
            ]))
            ->seeJson([
                'status' => (string) Status::createOWonStatus()
            ])
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function game_can_be_updated_for_drow()
    {
        $game = $this->createGame('OXOOXXXO-');

        $this
            ->put(route('game.update', [
                'id' => $game->getId(),
                'board' => 'OXOOXXXOX',
            ]))
            ->seeJson([
                'status' => (string) Status::createDrawStatus()
            ])
            ->assertResponseOk();
    }
}
