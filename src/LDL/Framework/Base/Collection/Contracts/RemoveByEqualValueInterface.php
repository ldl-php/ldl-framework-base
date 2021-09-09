<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Exception\LockingException;

interface RemoveByEqualValueInterface
{
    /**
     * Removes elements from a collection by value comparison
     *
     * @param $value
     * @param bool $strict
     * @throws LockingException
     * @throws RemoveException
     * @return int Amount of removed elements
     */
    public function removeByEqualValue($value, bool $strict = true) : int;
}