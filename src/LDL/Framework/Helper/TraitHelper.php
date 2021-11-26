<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Exception\InvalidArgumentException;
final class TraitHelper {

    /**
     * Imperative alias of trait_exists, if trait does not exists an InvalidArgumentException will be thrown
     *
     * @param string $trait
     * @param $autoload
     */
    public static function traitMustExist(string $trait, bool $autoload=true) : void
    {
        if (trait_exists($trait, $autoload)) {
            return;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Trait: "%s" is NOT a trait or it was not loaded properly',
                $trait
            )
        );
    }

    public static function getAllTraits(string $trait) : array
    {
        self::traitMustExist($trait);

        $traits = class_uses($trait);

        $foundTraits = [];

        array_map(static function($trait) use (&$foundTraits){
            $foundTraits[] = $trait;
            $foundTraits = array_merge($foundTraits, self::getAllTraits($trait));
        }, $traits);

        return $foundTraits;
    }
}