<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendInPositionInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait AppendInPositionInterfaceTrait
{
    use ClassRequirementHelperTrait;
    use AppendableInterfaceTrait {
        append as _append;
    }

    //<editor-fold desc="AppendWithOrderInterface methods">
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
    public function hasPosition(int $position) : bool
    {
        $this->_tAppendInPositionInterfaceTraitValidatePosition($position);
        return $position > $this->count();
    }

    /**
     * {@inheritdoc}
     */
    public function appendInPosition($item, int $position, $key = null): CollectionInterface
    {
        $this->requireImplements([AppendInPositionInterface::class, CollectionInterface::class]);
        $this->_append($item, $key);

        $this->_tAppendInPositionInterfaceTraitValidatePosition($position);

        if(AppendInPositionInterface::APPEND_POSITION_LAST === $position){
            return $this;
        }

        $items = $this->toArray();
        $lastKey = $this->getLastKey();
        $last = array_pop($items);

        if(AppendInPositionInterface::APPEND_POSITION_FIRST === $position){
            $this->setItems([$lastKey => $last] + $items);
            $this->setFirstKey($lastKey);
            $keys = array_keys($items);
            $this->setLastKey($keys[count($keys)-1]);

            return $this;
        }

        $i=1;

        $found = false;
        $result = [];

        foreach($items as $k => $v){
            $result[$k] = $v;

            if($i++ === $position){
                $result[$lastKey] = $last;
                $found = true;
            }

        }

        if(!$found){
            $msg = sprintf(
                'Position "%s" is undefined in this collection',
                $position
            );

            throw new \InvalidArgumentException($msg);
        }

        $keys = array_keys($result);

        $this->setItems($result);
        $this->setFirstKey($keys[0]);
        $this->setLastKey($keys[count($keys)-1]);

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