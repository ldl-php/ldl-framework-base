<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

interface ArrayFactoryInterface
{
    public function fromArray(array $data=[]) : ArrayFactoryInterface;
}
