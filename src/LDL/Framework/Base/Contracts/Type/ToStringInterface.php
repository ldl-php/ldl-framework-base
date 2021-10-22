<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToStringInterface extends LDLTypeInterface
{
    public const TYPE_METHOD_NAME = 'toString';
    public const TYPE_PRIMITIVE_METHOD_NAME = '__toString';

    /**
     * @return string
     */
    public function toString() : string;

    /**
     * @return string
     */
    public function __toString() : string;
}
