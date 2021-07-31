<?php

declare(strict_types=1);


namespace App\Storages\GameStorage;

use App\Domain\Game\Game;

interface GameStorage
{
    public function store(Game $game): void;

    public function get(string $gameId): ?Game;

    public function has(string $gameId): bool;

    public function delete(string $gameId): bool;
}
