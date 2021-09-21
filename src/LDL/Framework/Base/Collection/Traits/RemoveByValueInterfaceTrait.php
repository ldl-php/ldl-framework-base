<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByValueInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Helper\IterableHelper;

/**
 * Trait RemoveByValueInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see RemoveByValueInterface
 */
trait RemoveByValueInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="RemoveByValueInterface methods">
    public function removeByValue(
        $value,
        string $operator = ComparisonOperatorHelper::OPERATOR_SEQ,
        string $order = ComparisonOperatorHelper::COMPARE_LTR
    ) : int
    {
        $this->requireImplements([
            CollectionInterface::class,
            RemoveByValueInterface::class
        ]);

        $this->requireTraits([CollectionInterfaceTrait::class]);

        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockRemoveInterface){
            $this->checkLockRemove();
        }

        $removed = 0;

        $this->setItems(
            IterableHelper::filter($this, function($val, $key) use ($value, $operator, $order, &$removed) : bool {
                $compare = ComparisonOperatorHelper::compare($val, $value, $operator, $order);

                if(!$compare) {
                    return true;
                }

                if($this instanceof BeforeRemoveInterface){
                    $this->getBeforeRemove()->call($this, $this->get($key), $key);
                }

                $removed++;

                return false;

            })
        );

        return $removed;
    }
    //</editor-fold>

}