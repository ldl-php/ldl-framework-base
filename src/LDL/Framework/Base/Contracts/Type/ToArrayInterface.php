<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToArrayInterface extends LDLTypeInterface
{
    public const TO_ARRAY_TYPE_METHOD_NAME = 'toArray';

    /**
     * @param bool $useKeys
     * @return array
     */
    public function toArray(bool $useKeys=null) : array;
}
