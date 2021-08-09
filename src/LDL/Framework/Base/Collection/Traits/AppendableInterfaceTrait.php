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
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait AppendableInterfaceTrait
{
    use ClassRequirementHelperTrait;

    private $_instanceOfLockableObject;
    private $_instanceOfLockAppend;
    private $_instanceOfAppendVerifyKey;
    private $_instanceOfVerifyKey;

    //<editor-fold desc="AppendableInterface methods">
    public function append($item, $key = null): CollectionInterface
    {
        if(null !== $key){
            ArrayHelper::validateKey($key);
        }

        $this->requireImplements([AppendableInterface::class, CollectionInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        if(null === $this->_instanceOfLockableObject){
            $this->_instanceOfLockableObject = $this instanceof LockableObjectInterface;
        }

        if(null === $this->_instanceOfLockAppend){
            $this->_instanceOfLockAppend = $this instanceof LockAppendInterface;
        }

        if(null === $this->_instanceOfAppendVerifyKey){
            $this->_instanceOfAppendVerifyKey = $this instanceof HasDuplicateKeyVerificationAppendInterface;
        }

        if(null === $this->_instanceOfVerifyKey){
            $this->_instanceOfVerifyKey = $this instanceof HasDuplicateKeyVerificationInterface;
        }

        if($this->_instanceOfLockableObject){
            $this->checkLock();
        }

        if($this->_instanceOfLockAppend){
            $this->checkLockAppend();
        }

        $gKey = $this->getAutoincrementKey();

        if(null === $key){
            $key = $gKey;
        }

        $callables = [];

        if($this->hasKey($key)){
            if($this->_instanceOfAppendVerifyKey){
                $callables = $this->onAppendDuplicateKey();
            }

            if(!$this->_instanceOfAppendVerifyKey && $this->_instanceOfVerifyKey){
                $callables = $this->onDuplicateKey();
            }
        }

        foreach($callables as $callable){
            $key = $callable->call($this, $item, $key);
        }

        ArrayHelper::validateKey($key);

        if($this->hasKey($key)){
            $msg = sprintf(
                'Item with key: %s already exists, if you want to replace an item use %s',
                $key,
                ReplaceByKeyInterface::class
            );
            throw new \LogicException($msg);
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