<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Helper\IterableHelper;

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
    //</editor-fold>
}