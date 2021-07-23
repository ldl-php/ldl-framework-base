<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

abstract class ClassHelper
{
    /**
     * Obtains all traits which are implemented inside of a class
     *
     * @param string $class
     * @return array
     */
    public static function getAllTraits(string $class): array
    {
        $traits = array_flip(class_uses($class));

        $foundTraits = [];

        foreach($traits as $trait => $index){
            $uses = class_uses($trait);
            $foundTraits[$trait] = true;

            foreach($uses as $use){
                $foundTraits[$use] = true;
                $result = self::getAllTraits($use);

                foreach($result as $r){
                    $foundTraits[$r] = true;
                }
            }
        }

        $parentClasses = class_parents($class);

        if(count($parentClasses) === 0){
            return array_keys($foundTraits);
        }

        foreach ($parentClasses as $parentClass) {
            $traits = self::getAllTraits($parentClass);
            foreach($traits as $trait){
                $foundTraits[$trait] = true;
                $result = self::getAllTraits($trait);

                if(count($result) === 0){
                    continue;
                }

                foreach($result as $r){
                    $foundTraits[$r] = true;
                }
            }
        }

        return array_keys($foundTraits);
    }

    /**
     * Returns an array which the traits which are not used by this class.
     *
     * On success: An empty array will be returned
     * On Failure: An array containing the traits which are NOT implemented in the class will be returned
     *
     * @param string $class
     * @param iterable $traits
     * @return array
     */
    public static function hasTraits(string $class, iterable $traits) : array
    {
        $result = self::getAllTraits($class);
        $notIn = [];

        foreach($traits as $trait){
            if(!in_array($trait, $result, true)){
                $notIn[] = $trait;
            }
        }

        return $notIn;
    }

    /**
     * Returns an array which the traits which are not used by this class.
     *
     * On success: An empty array will be returned
     * On Failure: An array containing the traits which are NOT implemented in the class will be returned
     *
     * @param string $class
     * @param iterable $interfaces
     * @return array
     */
    public static function hasInterfaces(string $class, iterable $interfaces) : array
    {
        $result = class_implements($class);
        $notIn = [];

        foreach($interfaces as $interface){
            if(!in_array($interface, $result, true)){
                $notIn[] = $interface;
            }
        }

        return $notIn;
    }

    /**
     * @param string $class
     * @param iterable $traits
     * @throws \RuntimeException
     */
    public static function mustHaveTraits(string $class, iterable $traits) : void
    {
        $notIn = self::hasTraits($class, $traits);

        if(count($notIn) === 0){
            return;
        }

        $msg = sprintf("Class: %s does not use the following traits: %s", $class, implode(',', $notIn));
        throw new \RuntimeException($msg);
    }

    /**
     * @param string $class
     * @param iterable $interfaces
     * @throws \RuntimeException
     */
    public static function mustHaveInterfaces(string $class, iterable $interfaces) : void
    {
        $notIn = self::hasInterfaces($class, $interfaces);

        if(count($notIn) === 0){
            return;
        }

        $msg = sprintf("Class: %s does not use the following interfaces: %s", $class, implode(',', $notIn));
        throw new \RuntimeException($msg);
    }
}
