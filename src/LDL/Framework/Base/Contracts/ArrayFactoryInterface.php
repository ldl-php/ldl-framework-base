<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

interface ArrayFactoryInterface
{
    public static function fromArray(array $data=[]) : ArrayFactoryInterface;
}
