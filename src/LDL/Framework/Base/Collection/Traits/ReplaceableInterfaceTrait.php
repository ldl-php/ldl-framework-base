<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\HasDuplicateKeyVerificationInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceableInterface;
use LDL\Framework\Base\Collection\Exception\ReplaceException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait ReplaceableInterfaceTrait
{
    use ClassRequirementHelperTrait;

    private static $_instanceOfLockableObject;
    private static $_instanceOfLockReplace;
    private static $_instanceOfVerifyKey;

    //<editor-fold desc="ReplaceableInterface Methods">
    public function replace($item, $key) : CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            ReplaceableInterface::class
        ]);

        $this->requireTraits(CollectionInterfaceTrait::class);

        if(null === self::$_instanceOfLockableObject){
            self::$_instanceOfLockableObject = $this instanceof LockableObjectInterface;
        }

        if(null === self::$_instanceOfLockReplace){
            self::$_instanceOfLockReplace = $this instanceof LockReplaceInterface;
        }

        if(null === self::$_instanceOfVerifyKey){
            self::$_instanceOfVerifyKey = $this instanceof HasDuplicateKeyVerificationInterface;
        }

        if(self::$_instanceOfLockableObject){
            $this->checkLock();
        }

        if(self::$_instanceOfLockReplace){
            $this->checkLockReplace();
        }

        if(null !== $key){
            ArrayHelper::validateKey($key);
        }

        if($this instanceof BeforeReplaceInterface){
            $this->getBeforeReplace()->call($this, $item, $key);
        }

        if(false === $this->hasKey($key)){
            if(!self::$_instanceOfVerifyKey){
                throw new ReplaceException("Item with key: $key does not exists");
            }

            foreach($this->onDuplicateKey() as $callable){
                $callable->call($this, $item, $key);
            }
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