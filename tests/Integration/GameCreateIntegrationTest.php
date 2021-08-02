<?php

declare(strict_types=1);

namespace Integration;

use Symfony\Component\HttpFoundation\Response;
use TestCase;

class GameCreateIntegrationTest extends TestCase
{
    /**
     * @test
     */
    public function game_can_be_created_with_valid_board_state()
    {
        $this
            ->post(route('game.create', [
                'board' => '---OX----',
            ]))
            ->seeJsonStructure([
                'location'
            ])
            ->seeHeader('Location')
            ->assertResponseStatus(Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function game_cannot_be_created_without_board_state()
    {
        $this
            ->post(route('game.create'))
            ->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function game_cannot_be_created_with_invalid_board_state()
    {
        $this
            ->post(route('game.create', [
                'board' => '---XX----',
            ]))
            ->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function game_can_be_created_even_with_draw_state()
    {
        $this
            ->post(route('game.create', [
                'board' => 'XOXOXXOXO',
            ]))
            ->seeJsonStructure([
                'location'
            ])
            ->seeHeader('Location')
            ->assertResponseStatus(Response::HTTP_CREATED);
    }
}
