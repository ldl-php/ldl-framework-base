<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface AppendAfterKeyInterface
{
    /**
     * Append an element after a specific key to the collection
     *
     * @param mixed $item
     * @param mixed $afterKey
     * @param mixed $key
     * 
     * @return CollectionInterface
     */
    public function appendAfterKey($item, $afterKey, $key = null): CollectionInterface;
}
