<?php

namespace App\Domain\Board;

use App\Domain\Exceptions\WrongSignException;

class Mark
{
    public const X_SIGN = 'X';
    public const O_SIGN = 'O';

    public const ALLOWED_SIGNS = [
        self::X_SIGN,
        self::O_SIGN,
    ];

    /**
     * @param int $row
     * @param int $column
     * @param string $sign
     *
     * @throws WrongSignException
     */
    public function __construct(
        private int $row,
        private int $column,
        private string $sign
    )
    {
        self::checkSign($sign);
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return Mark
     * @throws WrongSignException
     */
    public static function createXMark(int $row, int $column)
    {
        return new self($row, $column, self::X_SIGN);
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return Mark
     * @throws WrongSignException
     */
    public static function createOMark(int $row, int $column)
    {
        return new self($row, $column, self::O_SIGN);
    }

    /**
     * @param string $sign
     *
     * @throws WrongSignException
     */
    private static function checkSign(string $sign): void
    {
        if (!self::isSignValid($sign)) {
            throw new WrongSignException($sign);
        }
    }

    /**
     * @param string $sign
     *
     * @return bool
     */
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
