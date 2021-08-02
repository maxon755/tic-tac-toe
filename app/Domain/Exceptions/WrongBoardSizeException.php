<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class WrongBoardSizeException extends Exception implements BoardStateException
{
    public function __construct(int $allowedBoardSize)
    {
        $message = "The board should square {$allowedBoardSize}x{$allowedBoardSize}";

        parent::__construct($message);
    }
}
