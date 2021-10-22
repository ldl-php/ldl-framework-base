<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

use LDL\Framework\Base\Exception\ToArrayException;

interface ToBooleanInterface extends LDLTypeInterface
{
    public const TO_BOOLEAN_TYPE_METHOD_NAME = 'toBoolean';

    /**
     * @throws ToArrayException
     * @return bool
     */
    public function toBoolean() : bool;
}
