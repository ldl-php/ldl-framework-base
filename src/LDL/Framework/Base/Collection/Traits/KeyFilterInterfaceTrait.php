<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Helper\RegexHelper;

trait KeyFilterInterfaceTrait
{
    use ResetCollectionTrait;

    //<editor-fold desc="KeyFilterInterface methods">
    public function filterByKeys(iterable $keys) : CollectionInterface
    {
        /**
         * @var CollectionInterface $self
         */
        $self = $this->_reset(clone($this));

        $keys = is_array($keys) ? $keys : \iterator_to_array($keys);

        $self->setItems(array_filter(\iterator_to_array($this, true), static function($key) use ($keys){
            return in_array($key, $keys, true);
        }, \ARRAY_FILTER_USE_KEY));

        return $self;
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
        RegexHelper::validate($regex);

        /**
         * @var CollectionInterface $self
         */
        $self = $this->_reset(clone($this));

        $self->setItems(array_filter(\iterator_to_array($this), static function($key) use ($regex){
            return (bool) preg_match($regex, $key);
        }, \ARRAY_FILTER_USE_KEY));

        return $self;
    }
    //</editor-fold>
}