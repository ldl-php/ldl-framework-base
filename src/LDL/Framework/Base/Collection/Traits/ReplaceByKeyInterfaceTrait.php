<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 *
 * WARNING: Do not use append or remove, this may cause an infinity loop
 * Be aware when comparing objects which have other deeply nested objects, PHP could throw a Fatal Error
 * PHP Fatal error:  Nesting level too deep - recursive dependency?
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceMissingKeyInterface;
use LDL\Framework\Base\Collection\Exception\ReplaceException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait ReplaceByKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;

    private $_instanceOfLockableObject;
    private $_instanceOfLockReplace;

    //<editor-fold desc="ReplaceByKeyInterface Methods">
    public function replaceByKey($item, $key) : CollectionInterface
    {
        if(null !== $key){
            ArrayHelper::validateKey($key);
        }

        $this->requireImplements([
            CollectionInterface::class,
            ReplaceByKeyInterface::class
        ]);

        $this->requireTraits(CollectionInterfaceTrait::class);

        if(null === $this->_instanceOfLockableObject){
            $this->_instanceOfLockableObject = $this instanceof LockableObjectInterface;
        }

        if(null === $this->_instanceOfLockReplace){
            $this->_instanceOfLockReplace = $this instanceof LockReplaceInterface;
        }

        if($this->_instanceOfLockableObject){
            $this->checkLock();
        }

        if($this->_instanceOfLockReplace){
            $this->checkLockReplace();
        }

        if($this instanceof BeforeReplaceInterface){
            $this->getBeforeReplace()->call($this, $item, $key);
        }

        if($this->hasKey($key)){
            if($this instanceof BeforeRemoveInterface){
                $this->getBeforeRemove()->call($this, $item, $key);
            }

            $this->setItem($item, $key);
            return $this;
        }

        if(!$this instanceof ReplaceMissingKeyInterface){
            throw new ReplaceException("Item with key: '$key' does not exists");
        }

        $this->onReplaceMissingKey()->call($this, $item, $key);

        return $this;
    }
    //</editor-fold>
}