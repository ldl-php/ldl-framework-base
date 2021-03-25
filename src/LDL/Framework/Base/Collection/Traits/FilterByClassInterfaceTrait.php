<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait FilterByClassInterfaceTrait
{
    use ResetCollectionTrait;

    //<editor-fold desc="FilterByClassInterface methods">
    public function filterByClass(string $class) : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = $this->_reset();

        if(false === class_exists($class)){
            throw new \InvalidArgumentException("Class '$class' does not exists");
        }

        foreach($this as $item){
            if(is_object($item) && $item instanceof $class){
                $collection->append($item);
            }
        }

        return $collection;
    }
    //</editor-fold>
}