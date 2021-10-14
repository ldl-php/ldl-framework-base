<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 * @see SelectionInterface
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByValueInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceByValueInterface;
use LDL\Framework\Base\Collection\Contracts\SelectionInterface;
use LDL\Framework\Base\Collection\Contracts\SelectionLockingInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Exception\LockingException;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;

trait SelectionInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var CollectionInterface
     */
    private $_tSelected;

    //<editor-fold desc="SelectionInterfaceTrait methods">
    public function select($key) : SelectionInterface
    {
        return $this->selectMany([$key]);
    }

    public function selectMany(iterable $keys) : SelectionInterface
    {
        $this->_createSelectedValuesInstance();

        if($this->_tSelected->isLocked()){
            $msg = 'Selection of items has been locked, can not select more items in this collection';
            throw new LockingException($msg);
        }

        foreach($keys as $key){
            /**
             * If offset does not exists, it will throw an UndefinedOffsetException
             */
            $this->get($key);
        }

        $this->_tSelected->appendMany($keys);

        return $this;
    }

    public function getSelectedItems() : CollectionInterface
    {
        $this->_createSelectedValuesInstance();
        return $this->_tSelected;
    }

    public function getSelectedValues() : array
    {
        $this->_createSelectedValuesInstance();

        $values = [];

        foreach($this->_tSelected as $key){
            $values[] = $this->get($key);
        }

        return $values;
    }

    public function hasSelection() : bool
    {
        $this->_createSelectedValuesInstance();
        return $this->_tSelected->count() > 0;
    }
    //</editor-fold>

    //<editor-fold desc="SelectionLockingInterface">
    public function lockSelection(): SelectionLockingInterface
    {
        $this->_createSelectedValuesInstance();
        $this->_tSelected->lock();
        return $this;
    }

    public function isSelectionLocked() : bool
    {
        $this->_createSelectedValuesInstance();
        return $this->_tSelected->isLocked();
    }
    //</editor-fold>

    //<editor-fold desc="Private methods">
    private function _createSelectedValuesInstance() : CollectionInterface
    {
        if(null !== $this->_tSelected) {
            return $this->_tSelected;
        }

        $this->requireImplements([CollectionInterface::class, SelectionInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $this->_tSelected = $this->_selectedItemsCollection();

        if(!$this instanceof BeforeRemoveInterface){
            return $this->_tSelected;
        }

        $this->getBeforeRemove()->append(function($collection, $item, $key){
            try{
                $this->_tSelected->removeByValue($key);
            }catch(LockingException $e){
                $this->_tSelected = $this->_selectedItemsCollection(
                    IterableHelper::filter($this->_tSelected, static function($v, $k) use ($key){
                        return $k !== $key;
                    })
                );

                $this->_tSelected->lock();
            }
        });

        return $this->_tSelected;
    }

    private function _selectedItemsCollection(iterable $items = null) : CollectionInterface
    {
        return new class($items) implements CollectionInterface, LockableObjectInterface, BeforeAppendInterface, BeforeRemoveInterface, BeforeReplaceInterface, AppendableInterface, RemoveByValueInterface, ReplaceByValueInterface, LockAppendInterface, LockRemoveInterface, LockReplaceInterface
        {
            use CollectionInterfaceTrait;
            use LockableObjectInterfaceTrait;

            use BeforeAppendInterfaceTrait;
            use BeforeRemoveInterfaceTrait;
            use BeforeReplaceInterfaceTrait;

            use AppendableInterfaceTrait;
            use AppendManyTrait;
            use RemoveByValueInterfaceTrait;
            use ReplaceByValueInterfaceTrait;

            use LockAppendInterfaceTrait;
            use LockRemoveInterfaceTrait;
            use LockReplaceInterfaceTrait;

            public function __construct(iterable $items = null)
            {
                $this->getBeforeAppend()->append(static function($collection, $item, $key){
                    ArrayHelper::validateKey($item);
                });

                if(null !== $items){
                    $this->appendMany($items, true);
                }
            }
        };
    }
    //</editor-fold>
}