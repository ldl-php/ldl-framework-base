<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface ReplaceableInterface
{
    /**
     * If the key already exists, it will be replaced, if the key does not exists
     * it will throw and Exception
     *
     * @param $item
     * @param $key
     * @throws \Exception if the value does not exist
     * @return CollectionInterface
     */
    public function replace($item, $key) : CollectionInterface;
}