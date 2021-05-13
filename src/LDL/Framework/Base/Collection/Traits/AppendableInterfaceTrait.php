<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceableInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait AppendableInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="AppendableInterface methods">
    public function append($item, $key = null): CollectionInterface
    {
        $this->requireImplements([AppendableInterface::class, CollectionInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockAppendInterface){
            $this->checkLockAppend();
        }

        $gKey = $this->getAutoincrementKey();

        if(null !== $key){
            ArrayHelper::validateKey($key);
            $gKey = $key;

            if($this->hasKey($gKey)){
                $msg = sprintf(
                    'Item with key: %s already exists, if you want to replace an item use %s',
                    $gKey,
                    ReplaceableInterface::class
                );
                throw new \LogicException($msg);
            }
        }

        if($this instanceof BeforeAppendInterface){
            $this->getBeforeAppend()->call($this, $item, $gKey);
        }

        if(null === $this->getFirstKey()){
            $this->setFirstKey($gKey);
        }

        $this->setLastKey($gKey);
        $this->setItem($item, $gKey);

        if(!$key){
            $this->setAutoincrementKey($gKey + 1);
        }

        $this->setCount($this->count() + 1);

        return $this;
    }
    //</editor-fold>
}