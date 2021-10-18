<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

use LDL\Framework\Base\Exception\ToArrayException;

interface ToBooleanInterface
{
    /**
     * @throws ToArrayException
     * @return bool
     */
    public function toBoolean() : bool;
}
