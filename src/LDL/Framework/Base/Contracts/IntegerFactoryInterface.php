<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\IntegerFactoryException;

interface IntegerFactoryInterface
{
    /**
     * @param int $integer
     * @throws IntegerFactoryException
     * @return IntegerFactoryInterface
     */
    public static function fromInteger(int $integer) : IntegerFactoryInterface;
}
