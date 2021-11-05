<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToBooleanInterface extends LDLTypeInterface
{
    public const TO_BOOLEAN_TYPE_METHOD_NAME = 'toBoolean';

    /**
     * @return bool
     */
    public function toBoolean() : bool;
}
