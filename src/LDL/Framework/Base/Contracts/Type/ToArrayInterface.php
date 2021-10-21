<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

use LDL\Framework\Base\Exception\ToArrayException;

interface ToArrayInterface extends LDLTypeInterface
{
    /**
     * @throws ToArrayException
     * @param bool $useKeys
     * @return array
     */
    public function toArray(bool $useKeys=null) : array;
}
