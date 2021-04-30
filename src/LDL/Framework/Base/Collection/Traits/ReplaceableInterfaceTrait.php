<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceableInterface;
use LDL\Framework\Base\Collection\Exception\ReplaceException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait ReplaceableInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="ReplaceableInterface Methods">
    public function replace($item, $key) : CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            ReplaceableInterface::class
        ]);

        $this->requireTraits(CollectionInterfaceTrait::class);

        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockReplaceInterface){
            $this->checkLockReplace();
        }

        if(null !== $key){
            ArrayHelper::validateKey($key);
        }

        if($this instanceof BeforeReplaceInterface){
            $this->getBeforeReplace()->call($this, $item, $key);
        }

        if(false === $this->hasKey($key)){
            if($this instanceof AppendableInterface){
                return $this->append($item, $key);
            }

            throw new ReplaceException("Item with key: $key does not exists");
        }

        if($this instanceof BeforeRemoveInterface){
            $this->getBeforeRemove()->call($this, $item, $key);
        }

        if($this instanceof BeforeAppendInterface){
            $this->getBeforeAppend()->call($this, $item, $key);
        }

        $this->setItem($item, $key);
        return $this;
    }
    //</editor-fold>
}