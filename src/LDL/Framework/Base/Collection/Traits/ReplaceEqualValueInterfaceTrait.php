<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 *
 * WARNING: Do not use append or remove, this may cause an infinity loop
 * Be aware when comparing objects which have other deeply nested objects, PHP could throw a Fatal Error
 * PHP Fatal error:  Nesting level too deep - recursive dependency?
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceEqualValueInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceMissingKeyInterface;
use LDL\Framework\Base\Collection\Exception\ReplaceException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait ReplaceEqualValueInterfaceTrait
{
    use ClassRequirementHelperTrait;

    private $_instanceOfLockableObject;
    private $_instanceOfLockReplace;

    //<editor-fold desc="ReplaceEqualValueInterface Methods">
    public function replaceByEqualValue($value, $replacement, bool $strict = true, int $limit = null) : CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            ReplaceEqualValueInterface::class
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
            $this->getBeforeReplace()->call($this, $value, $replacement);
        }

        if(false === $this->hasValue($value)){

            if(!$this instanceof ReplaceMissingKeyInterface){
                throw new ReplaceException("Item with value: $value does not exists");
            }

            $this->onReplaceMissingKey()->call($this, $value, $replacement);
        }

        if($this instanceof BeforeRemoveInterface){
            $this->getBeforeRemove()->call($this, $value, $replacement);
        }

        $found = 0;

        foreach($this as $key => $val){
            if($strict && $val !== $value){
                continue;
            }

            if(!$strict && $val != $value){
                continue;
            }

            $found++;

            if(null !== $limit && $found > $limit){
                break;
            }

            $this->setItem($replacement, $key);
        }

        return $this;
    }
    //</editor-fold>
}