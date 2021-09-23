<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Helper\IterableHelper;

/**
 * Trait RemoveByKeyInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see RemoveByKeyInterface
 */
trait RemoveByKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="RemoveByKeyInterface methods">
    public function removeByKey(
        $key,
        string $operator = ComparisonOperatorHelper::OPERATOR_SEQ,
        string $order = ComparisonOperatorHelper::COMPARE_LTR
    ) : int
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

        ArrayHelper::validateKey($key);

        $removed = 0;

        /**
         * Performance enhancement, IterableHelper::filter will go through every value
         * for strict equals comparison (===) this is not needed.
         */
        if(ComparisonOperatorHelper::isStrictlyEqualsOperator($operator))
        {
            if(!$this->hasKey($key)){
                return $removed;
            }

            if($this instanceof BeforeRemoveInterface){
                $this->getBeforeRemove()->call($this, $this->get($key), $key);
            }

            $this->removeItem($key);

            return ++$removed;
        }

        $this->setItems(
            IterableHelper::filter($this, function($val, $k) use ($key, $operator, $order) : bool {
                $compare = ComparisonOperatorHelper::compare($k, $key, $operator, $order);

                if(!$compare) {
                    return true;
                }

                if($this instanceof BeforeRemoveInterface){
                    $this->getBeforeRemove()->call($this, $this->get($key), $key);
                }

                return false;

            }, $removed)
        );

        return $removed;
    }

    public function removeLast() : CollectionInterface
    {
        $this->removeByKey($this->getLastKey(),
            ComparisonOperatorHelper::OPERATOR_SEQ,
            ComparisonOperatorHelper::COMPARE_LTR
        );

        return $this;
    }
    //</editor-fold>

}