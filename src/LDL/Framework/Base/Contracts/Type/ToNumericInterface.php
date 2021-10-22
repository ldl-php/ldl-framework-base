<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToNumericInterface extends LDLTypeInterface
{
    public const TYPE_METHOD_NAME = 'toNumeric';

    /**
     * @return mixed
     */
    public function toNumeric();
}
