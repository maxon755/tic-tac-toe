<?php

declare(strict_types=1);

namespace Integration;

use App\Storages\GameStorage\GameStorage;
use TestCase;

abstract class AbstractGameIntegrationTest extends TestCase
{
    /**
     * @var GameStorage
     */
    protected GameStorage $storage;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var GameStorage storage */
        $this->storage = resolve(GameStorage::class);
    }
}
