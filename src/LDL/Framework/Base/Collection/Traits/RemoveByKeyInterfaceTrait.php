<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait RemoveByKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="RemovableInterface methods">
    public function removeByKey($key): CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            RemoveByKeyInterface::class
        ]);

        $this->requireTraits([CollectionInterfaceTrait::class]);

        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockRemoveInterface){
            $this->checkLockRemove();
        }

        $exists = $this->hasKey($key);

        if(!$exists){
            throw new RemoveException("Item with key: $key does not exists");
        }

        if($this instanceof BeforeRemoveInterface){
            $this->getBeforeRemove()->call($this, $exists ? $this->get($key) : null, $key);
        }

        $this->removeItem($key);
        $this->setCount($this->count() - 1);

        $keys = $this->keys();
        $lastKey = count($keys);

        if(0 === $lastKey) {
            $this->setFirstKey(null);
            $this->setLastKey(null);
            return $this;
        }

        $this->setFirstKey($keys[0]);
        $this->setLastKey($keys[$lastKey - 1]);

        return $this;
    }

    public function removeLast() : CollectionInterface
    {
        $this->removeByKey($this->getLastKey());
        return $this;
    }
    //</editor-fold>

}