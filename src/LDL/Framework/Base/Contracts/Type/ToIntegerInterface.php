<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToIntegerInterface extends LDLTypeInterface
{
    public const TYPE_METHOD_NAME = 'toInteger';

    /**
     * @return int
     */
    public function toInteger() : int;
}
