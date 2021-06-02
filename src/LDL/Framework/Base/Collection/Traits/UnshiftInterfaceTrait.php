<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\UnshiftInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait UnshiftInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="UnshiftInterface methods">
    public function unshift($item, $key = null): CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, UnshiftInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockAppendInterface){
            $this->checkLockAppend();
        }

        if(null !== $key){
            ArrayHelper::validateKey($key);
        }

        $key = $key ?? 0;

        if($this instanceof BeforeAppendInterface){
            $this->getBeforeAppend()->call($this, $item, $key);
        }

        $this->setFirstKey($key);

        if(null === $this->getLastKey()) {
            $this->setLastKey($key);
        }

        if(is_string($key)){
            $this->setItems([$key => $item] + $this->toArray());
            return $this;
        }

        $result = [$key=>$item];
        $items = $this->toArray();

        array_walk( $items, static function($v, $k) use(&$result){
            if(is_int($k)){
                ++$k;
            }

            $result[$k] = $v;
        });

        $this->setItems($result);

        return $this;
    }
    //</editor-fold>
}