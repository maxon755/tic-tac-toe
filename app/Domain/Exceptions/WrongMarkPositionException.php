<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class WrongMarkPositionException extends Exception
{
    public function __construct(int $row, int $column)
    {
        parent::__construct("Mark position ${row}:${column} is not allowed");
    }
}
