<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

use LDL\Framework\Base\Exception\ToArrayException;

interface ToScalarInterface extends LDLTypeInterface
{
    /**
     * @throws ToArrayException
     * @return string|int|bool|float
     */
    public function toScalar();
}
