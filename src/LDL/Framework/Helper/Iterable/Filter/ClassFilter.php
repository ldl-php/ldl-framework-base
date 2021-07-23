<?php declare(strict_types=1);

/**
 * Helper which filters an iterable through a set of classes
 */

namespace LDL\Framework\Helper\Iterable\Filter;

use LDL\Framework\Helper\IterableHelper;

abstract class ClassFilter
{

    public static function filterByClass(
        string $class,
        iterable $values,
        bool $strict=true
    ) : array
    {
        return self::filterByClasses([$class], $values, $strict);
    }

    public static function filterByClasses(
        iterable $classes,
        iterable $values,
        bool $strict=true
    ) : array
    {
        /**
         * Validate Classes
         */
        $classes = IterableHelper::map($classes, static function($class){
            if(!is_string($class)){
                throw new \InvalidArgumentException(
                    sprintf(
                        'Given item in class collection is not of type string, "%s" given',
                        gettype($class)
                    )
                );
            }

            if(!class_exists($class)){
                throw new \InvalidArgumentException("Class '$class' does not exists");
            }

            return $class;
        });

        return IterableHelper::filter($values, static function($v) use ($classes, $strict){
            if(!is_object($v)){
                return false;
            }

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
        });
    }

    public static function filterByClassRecursive(string $className, iterable $values) : array
    {
        return self::filterByClassesRecursive([$className], $values);
    }

    public static function filterByClassesRecursive(iterable $classes, iterable $values) : array
    {
        $classes = IterableHelper::toArray($classes);

        $result = [];

        $filter = static function($item, $offset) use (&$filter, &$result, $classes){
            foreach($classes as $className){
                if(is_object($item) && get_class($item) === $className){
                    $result[$offset] = $item;
                }
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