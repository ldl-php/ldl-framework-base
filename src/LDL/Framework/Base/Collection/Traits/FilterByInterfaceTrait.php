<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait FilterByInterfaceTrait
{
    use ResetCollectionTrait;

    //<editor-fold desc="FilterByInterface methods">
    public function filterByInterface(string $interface) : CollectionInterface
    {
        return $this->filterByInterfaces([$interface], true);
    }

    public function filterByInterfaces(iterable $interfaces, bool $strict=true) : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = $this->_reset();

        /**
         * Validate interfaces
         */
        array_map(static function($interface){
            if(!is_string($interface) || false === interface_exists($interface)){
                throw new \InvalidArgumentException("Interface '$interface' does not exists");
            }
        }, is_array($interfaces) ? $interfaces : \iterator_to_array($interfaces));

        $values = array_filter(
            \iterator_to_array($this, true),
            static function($v, $k) use ($collection, $interfaces, $strict){
                if(false === $strict) {
                    return array_filter($interfaces, static function ($interface) use ($v) {
                        return $v instanceof $interface;
                    });
                }

                foreach($interfaces as $interface){
                    if(!$v instanceof $interface){
                        return false;
                    }
                }

                return true;
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