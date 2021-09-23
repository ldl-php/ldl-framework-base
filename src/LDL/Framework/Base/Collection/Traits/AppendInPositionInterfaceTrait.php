<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendInPositionInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

/**
 * Trait AppendInPositionInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see AppendInPositionInterface
 */
trait AppendInPositionInterfaceTrait
{
    use ClassRequirementHelperTrait;
    use AppendableInterfaceTrait {
        append as _append;
    }

    //<editor-fold desc="AppendInPositionInterface methods">
    /**
     * {@inheritdoc}
     */
    public function unshift($item ,$key=null) : CollectionInterface
    {
        return $this->appendInPosition(
            $item,
            AppendInPositionInterface::APPEND_POSITION_FIRST,
            $key
        );
    }

    /**
     * {@inheritdoc}
     */
    public function unshiftMany(iterable $items) : CollectionInterface
    {
        return $this->appendManyInPosition(
            $items,
            AppendInPositionInterface::APPEND_POSITION_FIRST
        );
    }

    /**
     * {@inheritdoc}
     */
    public function hasPosition(int $position) : bool
    {
        $this->_tAppendInPositionInterfaceTraitValidatePosition($position);
        return $position > $this->count();
    }

    public function appendManyInPosition(iterable $items, int $position) : CollectionInterface
    {
        $this->_tAppendInPositionInterfaceTraitValidatePosition($position);

        $this->requireImplements([
            AppendInPositionInterface::class,
            CollectionInterface::class
        ]);

        $count = $this->count();

        foreach($items as $key => $item) {
            $this->_append($item, $key);
        }

        if(AppendInPositionInterface::APPEND_POSITION_LAST === $position || $count === $position){
            return $this;
        }

        $items = array_slice($this->toArray(), $count);

        if(AppendInPositionInterface::APPEND_POSITION_FIRST === $position){
            $this->setItems($items + array_slice($this->toArray(), 0 , $count));
            return $this;
        }

        $i=1;

        $found = false;
        $result = [];

        foreach($this->toArray() as $k => $v){
            if($position === $i++){
                $result += $items;
                $found = true;
            }

            $result[$k] = $v;
        }

        if(!$found){
            $msg = sprintf(
                'Position "%s" is undefined in this collection',
                $position
            );

            throw new \InvalidArgumentException($msg);
        }

        $this->setItems($result);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function appendInPosition($item, int $position, $key = null): CollectionInterface
    {
        $this->_tAppendInPositionInterfaceTraitValidatePosition($position);

        $this->requireImplements([
            AppendInPositionInterface::class,
            CollectionInterface::class
        ]);

        if($position > $this->count()){
            $msg = sprintf(
                'Position "%s" is undefined in this collection',
                $position
            );

            throw new \InvalidArgumentException($msg);
        }

        $this->_append($item, $key);

        if(AppendInPositionInterface::APPEND_POSITION_LAST === $position || $position === $this->count()){
            return $this;
        }

        $items = $this->toArray();
        $lastKey = $this->getLastKey(); //Has key already resolved
        $last = array_pop($items);

        if(AppendInPositionInterface::APPEND_POSITION_FIRST === $position){
            $this->setItems([$lastKey => $last] + $items);
            return $this;
        }

        $i=1;

        $result = [];

        foreach($items as $k => $v){
            if($position === $i++){
                $result[$lastKey] = $last;
            }

            $result[$k] = $v;
        }

        $this->setItems($result);

        return $this;
    }
    //</editor-fold>

    //<editor-fold desc="Private methods">
    /**
     * Validates position argument
     *
     * @throws \InvalidArgumentException
     * @param int $position
     */
    private function _tAppendInPositionInterfaceTraitValidatePosition(int $position) : void
    {
        $validNegativePositions = [
            AppendInPositionInterface::APPEND_POSITION_FIRST,
            AppendInPositionInterface::APPEND_POSITION_LAST
        ];

        if($position <= 0 && !in_array($position, $validNegativePositions, true)){
            $msg = sprintf(
                'Position argument must be a non-negative integer, "%s" was given',
                $position
            );

            throw new \InvalidArgumentException($msg);
        }
    }
    //</editor-fold>

}