<?php

declare(strict_types=1);

namespace App\Domain\Bots;

use Exception;

class BotFactory
{
    public const SIMPLE_DIFFICULTY = 'simple';

    private $bots = [
        self::SIMPLE_DIFFICULTY => SimpleBot::class,
        // more bots goes here ...
    ];

    public function createBot(string $difficulty, string $markSign): AbstractBot
    {
        if (!array_key_exists($difficulty, $this->bots)) {
            throw new Exception('Unsupported difficulty');
        }

        $botClass = $this->bots[$difficulty];

        return new $botClass($markSign);
    }
}
