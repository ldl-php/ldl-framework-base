<?php declare(strict_types=1);
/**
 * Helper which filters an iterable through a set of interfaces
 */

namespace LDL\Framework\Helper\Iterable\Filter;

use LDL\Framework\Helper\IterableHelper;

abstract class InterfaceFilter
{
    public static function filterByInterface(
        string $interface,
        iterable $values
    ) : array
    {
        return self::filterByInterfaces([$interface], $values,true);
    }

    public static function filterByInterfaces(
        iterable $interfaces,
        iterable $values,
        bool $strict=true
    ) : array
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

        return IterableHelper::filter($values, static function($v) use ($interfaces, $strict){
            if(false === $strict) {
                return IterableHelper::filter($interfaces, static function ($interface) use ($v) {
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

    public static function filterByInterfaceRecursive(
        string $interface,
        iterable $values
    ) : array
    {
        return self::filterByInterfacesRecursive([$interface], $values);
    }

    public static function filterByInterfacesRecursive(
        iterable $interfaces,
        iterable $values
    ) : array
    {
        $result = [];
        $interfaces = IterableHelper::toArray($interfaces);

        $filter = static function($item, $offset) use (&$filter, $result, $interfaces){
            foreach($interfaces as $interface){
                if(!$item instanceof $interface){
                    continue;
                }

                $result[$offset] = $item;
            }

            if($item instanceof \Traversable){
                foreach($item as $o => $i){
                    $filter($i, $o);
                }
            }

            return null;
        };

        foreach($values as $offset => $item){
            $filter($item, $offset);
        }

        return $result;
    }
}