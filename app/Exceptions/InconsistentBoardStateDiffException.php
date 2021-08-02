<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InconsistentBoardStateDiffException extends Exception
{
    public function __construct()
    {
        $message = "Provided board is not incremental change of previous one";

        parent::__construct($message);
    }
}
