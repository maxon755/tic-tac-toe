<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class WrongBoardSizeException extends Exception implements BoardStateException
{

}
