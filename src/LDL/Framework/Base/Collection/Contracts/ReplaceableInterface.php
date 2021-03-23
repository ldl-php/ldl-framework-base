<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\ReplaceException;
use LDL\Framework\Base\Exception\LockingException;

interface ReplaceableInterface
{
    /**
     * @param $item
     * @param $key
     */
    public function onBeforeReplace($item, $key): void;

    /**
     * If the key already exists, it will be replaced, if the key does not exists
     * it will throw a ReplaceException
     *
     * @param $item
     * @param $key
     *
     * @throws LockingException
     * @throws ReplaceException
     * @throws InvalidKeyException
     *
     * @return CollectionInterface
     */
    public function replace($item, $key) : CollectionInterface;
}