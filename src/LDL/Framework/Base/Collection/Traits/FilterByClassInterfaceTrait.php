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
        /**
         * @var CollectionInterface $collection
         */
        $collection = $this->_reset();

        /**
         * Validate Classes
         */
        array_map(static function($class){
            if(!is_string($class) || false === class_exists($class)){
                throw new \InvalidArgumentException("Class '$class' does not exists");
            }
        }, is_array($classes) ? $classes : \iterator_to_array($classes));

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
    //</editor-fold>
}