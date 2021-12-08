<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\ArrayFactoryException;

interface ArrayFactoryInterface
{
    /**
     * @param array $data
     * @throws ArrayFactoryException
     * @return mixed
     */
    public static function fromArray(array $data=[]);
}
