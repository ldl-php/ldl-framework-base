<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;

interface CallableCollectionInterface extends CollectionInterface, AppendableInterface, LockAppendInterface, RemoveByKeyInterface, LockRemoveInterface, LockableObjectInterface
{

    /**
     * @param mixed ...$params
     */
    public function call(...$params) : void;

    /**
     * @param mixed &...$params
     */
    public function callByRef(&...$params) : void;
}