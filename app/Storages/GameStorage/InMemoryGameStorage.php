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
        $this->redisManager->set($this->withPrefix($game->getId()), serialize($game));
    }

    public function get(string $gameId): ?Game
    {
        $game = $this->redisManager->get($this->withPrefix($gameId));

        return $game ? unserialize($game) : null;
    }

    public function getAll(): array
    {
        $gameKeys = $this->redisManager->keys('games:*');

        $games = array_map(function (string $gameKey) {
            return unserialize($this->redisManager->get($gameKey));
        }, $gameKeys);

        return $games;
    }

    public function has(string $gameId): bool
    {
        return (bool)$this->redisManager->exists($this->withPrefix($gameId));
    }

    public function delete(string $gameId): bool
    {
        return (bool)$this->redisManager->del($this->withPrefix($gameId));
    }

    private function withPrefix(string $key): string
    {
        return "games:$key";
    }
}
