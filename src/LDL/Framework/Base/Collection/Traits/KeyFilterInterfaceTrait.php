<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\KeyFilterInterface;
use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\RegexHelper;

trait KeyFilterInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="KeyFilterInterface methods">
    public function filterByKeys(iterable $keys) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, KeyFilterInterface::class]);

        $keys = IterableHelper::toArray($keys);

        return $this->filter(static function($key) use ($keys){
            return in_array($key, $keys, true);
        }, \ARRAY_FILTER_USE_KEY);
    }

    public function filterByKey(string $key)
    {
        try{
            return $this->filterByKeys([$key])->getFirst();
        }catch(CollectionException $e){
            throw new CollectionException("Could not filter by key: \"$key\", key does not exists");
        }
    }

    public function filterByKeyRegex(string $regex) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, KeyFilterInterface::class]);

        RegexHelper::validate($regex);

        return $this->filter(static function($key) use ($regex){
            return (bool) preg_match($regex, $key);
        }, \ARRAY_FILTER_USE_KEY);
    }
    //</editor-fold>
}