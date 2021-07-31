<?php

declare(strict_types=1);

namespace App\Storages\GameStorage;

use App\Domain\Game\Game;
use Illuminate\Redis\RedisManager;

class InMemoryGameStorage implements GameStorage
{
    public function __construct(private RedisManager $redisManager)
    {
    }

    public function store(Game $game): void
    {
        $this->redisManager->set('games:' . $game->getId(), serialize($game));
    }

    public function get(string $gameId): ?Game
    {
        $game = $this->redisManager->get('games:' . $gameId);

        return $game ? unserialize($game) : null;
    }
}
