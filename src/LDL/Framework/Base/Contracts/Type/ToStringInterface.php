<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToStringInterface extends LDLTypeInterface
{
    public const TO_STRING_TYPE_METHOD_NAME = 'toString';

    /**
     * @return string
     */
    public function toString() : string;

    /**
     * @return string
     */
    public function __toString() : string;
}
