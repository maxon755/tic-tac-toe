<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class WrongSignException extends Exception
{
    public function __construct(string $sign)
    {
        parent::__construct("Sign ${sign} is not allowed");
    }
}
