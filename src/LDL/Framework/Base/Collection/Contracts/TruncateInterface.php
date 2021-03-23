<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Exception\LockingException;

interface TruncateInterface
{
    /**
     * @throws LockingException
     *
     * @return CollectionInterface
     */
    public function truncate() : CollectionInterface;
}