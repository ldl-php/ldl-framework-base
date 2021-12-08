<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\IterableFactoryException;

interface IterableFactoryInterface
{
    /**
     * @param iterable $items
     * @throws IterableFactoryException
     * @return mixed
     */
    public static function fromIterable(iterable $items);
}
