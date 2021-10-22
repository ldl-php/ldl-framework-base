<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToNumericInterface extends LDLTypeInterface
{
    public const TO_NUMERIC_TYPE_METHOD_NAME = 'toNumeric';

    /**
     * @return mixed
     */
    public function toNumeric();
}
