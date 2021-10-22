<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToArrayKeyInterface extends LDLTypeInterface
{
    public const TO_ARRAY_KEY_TYPE_METHOD_NAME = 'toArrayKey';

    /**
     * @return string|int
     */
    public function toArrayKey();
}
