<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Exception\RuntimeException;
use LDL\Framework\Base\Exception\InvalidArgumentException;

final class ClassHelper
{

    //<editor-fold desc="Class method related methods">

    /**
     * Imperative alias of class_exists, if class does not exists an InvalidArgumentException will be thrown
     *
     * @param string $class
     * @param $autoload
     */
    public static function classMustExist(string $class, bool $autoload=true) : void
    {
        if (class_exists($class, $autoload)) {
            return;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Class: "%s" is NOT a class or it was not loaded properly',
                $class
            )
        );
    }


    /**
     * Determines if a $class has a given $method
     *
     * NOTE: Method names are case sensitive by default
     *
     * @param string $class
     * @param string $method
     * @param bool $caseSensitive
     *
     * @return bool
     */
    public static function hasMethod(string $class, string $method, bool $caseSensitive=true) : bool
    {
        return count(self::hasMethods($class, [$method], $caseSensitive)) === 0;
    }

    /**
     * Returns an array with methods not available in the class passed as an argument
     *
     * On success: An empty array will be returned, this indicates that the class contains all passed methods
     * On Failure: An array containing the methods which are NOT implemented in the class will be returned
     *
     * NOTE: Comparison is case sensitive by default
     *
     * @param string $class , class name to be checked
     * @param iterable $methods , collection of methods to be checked
     * @param bool $caseSensitive
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public static function hasMethods(
        string $class,
        iterable $methods,
        bool $caseSensitive=true
    ) : array
    {
        self::classMustExist($class);

        $availableMethods = get_class_methods($class);

        if(!$caseSensitive) {
            /**
             * Some people get funky with method names, namely Sara :D
             *
             * https://github.com/sgolemon/table-flip/blob/master/src/TableFlip.php
             *
             * If we'd use strtolower we would screw those up
             */
            $availableMethods = array_map(static function ($item) {
                return mb_strtolower($item, 'UTF-8');
            }, $availableMethods);
        }

        return IterableHelper::filter(
            $methods,
            static function($method) use ($availableMethods, $caseSensitive){
                if(!$caseSensitive) {
                    $method = mb_strtolower($method, 'UTF-8');
                }
                return !in_array($method, $availableMethods, true);
            }
        );
    }

    /**
     * Determines if a $class contains all $methods passed, if it doesn't a RuntimeException will be thrown.
     *
     * NOTE: Comparison is done in a case sensitive way by default
     *
     * @param string $class
     * @param iterable $methods
     * @param bool $caseSensitive
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function mustHaveMethods(string $class, iterable $methods, bool $caseSensitive=true) : void
    {
        $notIn = self::hasMethods($class, $methods, $caseSensitive);

        if(count($notIn) === 0){
            return;
        }

        throw new RuntimeException(
            sprintf(
                'Class: %s does not has the following methods: %s',
                $class,
                implode(',', $notIn)
            )
        );
    }

    /**
     * Determines if a $class implements a $method, $method name is case insensitive
     *
     * NOTE: Alias of self::mustHaveMethods (Syntax sugar for single values)
     *
     * @param string $class
     * @param string $method
     * @param bool $caseSensitive
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function mustHaveMethod(string $class, string $method, bool $caseSensitive=true) : void
    {
        self::mustHaveMethods($class, [$method], $caseSensitive);
    }

    //</editor-fold>

    //<editor-fold desc="Class trait methods">
    /**
     * Obtains all traits which are implemented inside of a class
     *
     * @param string $class
     * @throws InvalidArgumentException if the given $class does not exists
     *
     * @return string[]
     */
    public static function getAllTraits(string $class) : array
    {
        self::classMustExist($class);

        $foundTraits = [];

        array_map(static function($trait) use (&$foundTraits){
            $foundTraits[] = $trait;
            $foundTraits = array_merge($foundTraits, TraitHelper::getAllTraits($trait));
        }, class_uses($class));

        $parentClasses = class_parents($class);

        if(count($parentClasses) === 0){
            return array_keys(array_flip($foundTraits));
        }

        array_map(static function($parentClass) use (&$foundTraits){
            $foundTraits = array_merge($foundTraits, self::getAllTraits($parentClass));
        }, $parentClasses);

        return array_keys(array_flip($foundTraits));
    }

    /**
     * Returns an array of strings, each string value represents a trait which is not used by the passed $class argument
     *
     * On success: An empty array will be returned (all traits are present in said class)
     * On Failure: An array containing the traits which are NOT implemented in the class will be returned
     *
     * @param string $class
     * @param iterable $traits
     * @param bool $caseSensitive
     *
     * @return string[]
     * @throws InvalidArgumentException
     */
    public static function hasTraits(string $class, iterable $traits, bool $caseSensitive=true) : array
    {
        $allTraits = self::getAllTraits($class);

        if(!$caseSensitive){
            $allTraits = IterableHelper::map($traits, static function($trait){
                return mb_strtolower($trait, 'UTF-8');
            });
        }

        return IterableHelper::filter($traits, static function($trait) use ($allTraits, $caseSensitive){
            if(!$caseSensitive) {
                $trait = mb_strtolower($trait, 'UTF-8');
            }

            return !in_array($trait, $allTraits, true);
        });
    }

    /**
     * Returns a boolean value which determines if the class uses a trait or not
     *
     * true if $class uses trait $trait
     * false if $class does not uses trait $trait
     *
     * NOTE: Alias of self::hasTraits (syntax sugar)
     *
     * @param string $class
     * @param string $trait
     * @param bool $caseSensitive
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function hasTrait(string $class, string $trait, bool $caseSensitive=true) : bool
    {
        return count(self::hasTraits($class,[$trait], $caseSensitive)) === 0;
    }

    /**
     * If the passed $class argument does not contains all traits passed in $traits, a RuntimeException will be thrown
     *
     * @param string $class
     * @param iterable $traits
     * @param bool $caseSensitive
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function mustHaveTraits(string $class, iterable $traits, bool $caseSensitive=true) : void
    {
        $notIn = self::hasTraits($class, $traits, $caseSensitive);

        if(count($notIn) === 0){
            return;
        }

        throw new RuntimeException(
            sprintf(
                'Class: %s does not use the following traits: %s',
                $class,
                implode(',', $notIn
                )
            )
        );
    }

    /**
     * Alias of self::mustHaveTraits
     *
     * @param string $class
     * @param string $trait
     * @param bool $caseSensitive
     *
     * @see ClassHelper::mustHaveTraits
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function mustHaveTrait(string $class, string $trait, bool $caseSensitive=true) : void
    {
        self::mustHaveTraits($class, [$trait], $caseSensitive);
    }
    //</editor-fold>

    //<editor-fold desc="Class interface methods">

    /**
     * Returns an array which the traits which are not used by this class.
     *
     * On success: An empty array will be returned
     * On Failure: An array of strings containing the interfaces which are NOT implemented in the class will be returned
     *
     * @param string $class
     * @param iterable $interfaces
     *
     * @throws InvalidArgumentException if the given $class argument is not a class or does not exists
     *
     * @return string[]
     */
    public static function hasInterfaces(string $class, iterable $interfaces) : array
    {
        self::classMustExist($class);

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
     * Returns a boolean value which determines if the class implements an interface or not
     *
     * true if $class implements interface $trait
     * false if $class does not implements trait $trait
     *
     * NOTE: Alias of self::hasInterfaces (syntax sugar)
     *
     * @param string $class
     * @param string $interface
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function hasInterface(string $class, string $interface) : bool
    {
        return count(self::hasInterfaces($class,[$interface])) === 0;
    }

    /**
     * Determines if a $class implements a set of $interfaces, if all $interfaces sent are not implemented
     * on $class, a RuntimeException will be thrown
     *
     * @param string $class
     * @param iterable $interfaces
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function mustHaveInterfaces(string $class, iterable $interfaces) : void
    {
        $notIn = self::hasInterfaces($class, $interfaces);

        if(count($notIn) === 0){
            return;
        }

        throw new RuntimeException(
            sprintf(
                'Class: %s does not use the following interfaces: %s',
                $class,
                implode(',', $notIn)
            )
        );
    }

    /**
     * Determines if a class implements an interface, if it doesn't a RuntimeException will be thrown
     *
     * NOTE: Alias of self::mustHaveInterfaces (syntax sugar)
     *
     * @param string $class
     * @param string $interface
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function mustHaveInterface(string $class, string $interface) : void
    {
        self::mustHaveInterfaces($class, [$interface]);
    }

    //</editor-fold>

}
