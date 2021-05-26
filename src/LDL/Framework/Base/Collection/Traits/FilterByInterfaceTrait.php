<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;

trait FilterByInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByInterface methods">
    public function filterByInterface(string $interface) : CollectionInterface
    {
        return $this->filterByInterfaces([$interface], true);
    }

    public function filterByInterfaces(iterable $interfaces, bool $strict=true) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByInterface::class]);

        /**
         * Validate interfaces
         */
        IterableHelper::map($interfaces, static function($interface){
            if(!is_string($interface)){
                throw new \InvalidArgumentException(
                    sprintf(
                        'Given item in interface collection is not of type string, "%s" given',
                        gettype($interface)
                    )
                );
            }

            if(!interface_exists($interface)){
                throw new \InvalidArgumentException("Interface '$interface' does not exists");
            }
        });

        $interfaces = IterableHelper::toArray($interfaces);

        return $this->filter(static function($v) use ($interfaces, $strict){
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
        });
    }

    public function filterByInterfaceRecursive(string $interface) : CollectionInterface
    {
        return $this->filterByInterfacesRecursive([$interface]);
    }

    public function filterByInterfacesRecursive(iterable $interfaces) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = $this->getEmptyInstance();

        $interfaces = IterableHelper::toArray($interfaces);

        $filter = static function($item, $offset) use (&$filter, $collection, $interfaces){
            foreach($interfaces as $interface){
                if(!$item instanceof $interface){
                    continue;
                }

                if($collection instanceof AppendableInterface){
                    return $collection->append($item, $offset);
                }

                $collection->setItem($item, $offset);
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