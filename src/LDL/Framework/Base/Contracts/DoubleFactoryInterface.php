<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\DoubleFactoryException;

interface DoubleFactoryInterface
{
    /**
     * Remember: Floats are only an illusion in PHP, the float keyword is only kept due to "historical" reasons
     *
     * @param float $integer
     * @throws DoubleFactoryException
     * @return mixed
     */
    public static function fromDouble(float $integer);
}
