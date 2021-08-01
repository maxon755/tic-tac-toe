<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class CellIsNotEmptyException extends Exception
{
    public function __construct(int $row, int $column)
    {
        $message = "Cell [$row:$column] is already taken";

        parent::__construct($message);
    }
}
