<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\StringFactoryException;

interface StringFactoryInterface
{
    /**
     * @param string $items
     * @throws StringFactoryException
     * @return mixed
     */
    public static function fromString(string $items);
}
