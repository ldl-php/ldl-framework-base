<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface TruncateInterface
{
    /**
     * @return CollectionInterface
     */
    public function truncate() : CollectionInterface;
}