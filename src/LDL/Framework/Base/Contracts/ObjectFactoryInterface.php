<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\ObjectFactoryException;

interface ObjectFactoryInterface
{
    /**
     * @param object $obj
     * @throws ObjectFactoryException
     * @return ObjectFactoryInterface
     */
    public static function fromObject(object $obj) : ObjectFactoryInterface;
}
