<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class WrongMarksCountException extends Exception implements BoardStateException
{

}
