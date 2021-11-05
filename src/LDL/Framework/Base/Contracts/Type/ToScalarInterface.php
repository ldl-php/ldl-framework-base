<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToScalarInterface extends LDLTypeInterface
{
    public const TO_SCALAR_TYPE_METHOD_NAME = 'toScalar';

    /**
     * @return string|int|bool|float
     */
    public function toScalar();
}
