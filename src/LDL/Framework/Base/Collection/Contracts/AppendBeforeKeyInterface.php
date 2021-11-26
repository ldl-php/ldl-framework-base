<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface AppendBeforeKeyInterface
{
    /**
     * Append an element before a specific key to the collection
     *
     * @param mixed $item
     * @param mixed $beforeKey
     * @param mixed $key
     *
     * @return CollectionInterface
     */
    public function appendBeforeKey($item, $beforeKey, $key = null): CollectionInterface;
}
