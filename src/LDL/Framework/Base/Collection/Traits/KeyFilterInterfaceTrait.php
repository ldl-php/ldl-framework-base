<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait KeyFilterInterfaceTrait
{
    //<editor-fold desc="KeyFilterInterface methods">
    public function filterByKeys(iterable $keys) : CollectionInterface
    {
        /**
         * @var CollectionInterface $self
         */
        $self = clone($this);

        $keys = is_array($keys) ? $keys : \iterator_to_array($keys);

        $self->items = array_filter($this->items, static function($key) use ($keys){
            return in_array($key, $keys, true);
        }, \ARRAY_FILTER_USE_KEY);

        return $self;
    }

    public function filterByKey(string $key)
    {
        return $this->filterByKeys([$key])->getFirst();
    }

    public function filterByKeyRegex(string $regex) : CollectionInterface
    {
        $regex = preg_quote($regex, '#');

        $self = clone($this);

        $self->items = array_filter($this->items, static function($key) use ($regex){
            return false !== preg_match($key, $regex);
        }, \ARRAY_FILTER_USE_KEY);

        return $self;
    }
    //</editor-fold>
}