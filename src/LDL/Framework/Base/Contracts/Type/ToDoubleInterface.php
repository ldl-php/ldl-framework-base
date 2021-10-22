<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToDoubleInterface extends LDLTypeInterface
{
    public const TO_DOUBLE_TYPE_METHOD_NAME = 'toDouble';

    /**
     * @return float
     */
    public function toDouble() : float;
}
