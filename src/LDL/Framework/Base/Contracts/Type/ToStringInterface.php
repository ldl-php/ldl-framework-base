<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToStringInterface extends LDLTypeInterface
{
    public function toString() : string;
}
