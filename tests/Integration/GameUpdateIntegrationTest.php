<?php

declare(strict_types=1);

namespace Integration;

use App\Domain\Game\Status;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @test
     */
    public function non_existing_game_can_not_be_updated()
    {
        $this
            ->put(route('game.update', [
                'id' => 'some_id',
                'board' => '----X----',
            ]))
            ->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
}
