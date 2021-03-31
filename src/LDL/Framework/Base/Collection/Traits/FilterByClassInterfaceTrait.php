<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait FilterByClassInterfaceTrait
{
    use ResetCollectionTrait;

    //<editor-fold desc="FilterByClassInterface methods">
    public function filterByClass(string $class) : CollectionInterface
    {
        return $this->filterByClasses([$class]);
    }

    public function filterByClasses(iterable $classes, bool $strict=true) : CollectionInterface
    {
        $classes = is_array($classes) ? $classes : \iterator_to_array($classes, true);

        /**
         * @var CollectionInterface $collection
         */
        $collection = $this->_reset(clone($this));

        /**
         * Validate Classes
         */
        array_map(static function($class){
            if(!is_string($class) || false === class_exists($class)){
                throw new \InvalidArgumentException("Class '$class' does not exists");
            }
        }, $classes);

        $values = array_filter(
            \iterator_to_array($this, true),
            static function($v, $k) use ($collection, $classes, $strict){
                if(false === $strict) {
                    return array_filter($classes, static function ($class) use ($v) {
                        return get_class($v) === $class || is_subclass_of($v, $class);
                    });
                }

                foreach($classes as $class){
                    if(get_class($v) === $class){
                        return true;
                    }
                }

                return false;
            },
            \ARRAY_FILTER_USE_BOTH
        );

        if($collection instanceof AppendableInterface){
            return $collection->appendMany($values, true);
        }

        $collection->items = $values;

        return $collection;
    }

    public function filterByClassRecursive(string $className) : CollectionInterface
    {
        $collection = clone($this);
        $collection->truncate();

        $filter = static function($item, $offset) use (&$filter, $collection, $className){
            if(is_object($item) && get_class($item) === $className){

                if($collection instanceof AppendableInterface){
                    return $collection->append($item, $offset);
                }

                $collection->items[$offset] = $item;
            }

            if($item instanceof \Traversable){
                foreach($item as $o => $i){
                    $filter($i, $o);
                }
            }

            return null;
        };

        foreach($this as $offset => $item){
            $filter($item, $offset);
        }

        return $collection;
    }
    //</editor-fold>
}