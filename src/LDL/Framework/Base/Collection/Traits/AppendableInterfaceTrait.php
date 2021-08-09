<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\HasDuplicateKeyVerificationAppendInterface;
use LDL\Framework\Base\Collection\Contracts\HasDuplicateKeyVerificationInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceableInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait AppendableInterfaceTrait
{
    use ClassRequirementHelperTrait;

    private static $_instanceOfLockableObject;
    private static $_instanceOfLockAppend;
    private static $_instanceOfAppendVerifyKey;
    private static $_instanceOfVerifyKey;

    //<editor-fold desc="AppendableInterface methods">
    public function append($item, $key = null): CollectionInterface
    {
        $this->requireImplements([AppendableInterface::class, CollectionInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        if(null === self::$_instanceOfLockableObject){
            self::$_instanceOfLockableObject = $this instanceof LockableObjectInterface;
        }

        if(null === self::$_instanceOfLockAppend){
            self::$_instanceOfLockAppend = $this instanceof LockAppendInterface;
        }

        if(null === self::$_instanceOfAppendVerifyKey){
            self::$_instanceOfAppendVerifyKey = $this instanceof HasDuplicateKeyVerificationAppendInterface;
        }

        if(null === self::$_instanceOfVerifyKey){
            self::$_instanceOfVerifyKey = $this instanceof HasDuplicateKeyVerificationInterface;
        }

        if(self::$_instanceOfLockableObject){
            $this->checkLock();
        }

        if(self::$_instanceOfLockAppend){
            $this->checkLockAppend();
        }

        if(null !== $key){
            ArrayHelper::validateKey($key);
        }

        $gKey = $this->getAutoincrementKey();

        if(null === $key){
            $key = $gKey;
        }

        if($this->hasKey($key)){
            $callables = null;

            if(self::$_instanceOfAppendVerifyKey){
                $callables = $this->onAppendDuplicateKey();
            }

            if(!self::$_instanceOfAppendVerifyKey && self::$_instanceOfVerifyKey){
                $callables = $this->onDuplicateKey();
            }

            if(null === $callables){
                $msg = sprintf(
                    'Item with key: %s already exists, if you want to replace an item use %s',
                    $key,
                    ReplaceableInterface::class
                );
                throw new \LogicException($msg);
            }

            foreach($callables as $callable){
                $key = $callable->call($this, $item, $key);
            }

            ArrayHelper::validateKey($key);

            if($this->hasKey($key)){
                $msg = sprintf(
                    'Item with key: %s already exists, if you want to replace an item use %s',
                    $key,
                    ReplaceableInterface::class
                );
                throw new \LogicException($msg);
            }
        }

        $this->increaseAutoIncrement();

        if($this instanceof BeforeAppendInterface){
            $this->getBeforeAppend()->call($this, $item, $key);
        }

        if(null === $this->getFirstKey()){
            $this->setFirstKey($key);
        }

        $this->setLastKey($key);
        $this->setItem($item, $key);
        $this->setCount($this->count() + 1);

        return $this;
    }
    //</editor-fold>
}