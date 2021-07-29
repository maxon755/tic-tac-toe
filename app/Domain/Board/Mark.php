<?php

namespace App\Domain\Board;

use Exception;

class Mark
{
    public const ALLOWED_SIGNS = [
        'X',
        'O',
    ];

    public function __construct(
        private int $row,
        private int $column,
        private string $sign
    )
    {
        self::checkSign($sign);
    }

    private static function checkSign(string $sign): void
    {
        if (!self::isSignValid($sign)) {
            throw new Exception("Sign ${sign} is not allowed");
        }
    }

    public static function isSignValid(string $sign): bool
    {
        return in_array($sign, self::ALLOWED_SIGNS);
    }

    /**
     * @return int
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @return int
     */
    public function getColumn(): int
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getSign(): string
    {
        return $this->sign;
    }
}
