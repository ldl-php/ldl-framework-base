<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\ToArrayException;

interface ToArrayInterface
{
    /**
     * @throws ToArrayException
     * @return array
     */
    public function toArray() : array;
}
