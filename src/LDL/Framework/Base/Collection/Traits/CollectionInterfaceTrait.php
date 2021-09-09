<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;

trait CollectionInterfaceTrait
{
    /**
     * Maintains the count of elements inside the collection
     * @var int
     */
    private $count = 0;

    /**
     * Holds all items
     * @var array
     */
    private $items = [];

    /**
     * Holds the key of the last appended item
     * @var number|string
     */
    private $last;

    /**
     * Holds the key of the first appended item
     * @var number|string
     */
    private $first;

    //<editor-fold desc="CollectionInterface methods">
    public function get($key)
    {
        ArrayHelper::mustHaveKey($this->items, $key);

        $item = $this->items[$key];

        return is_object($item) && $this->_isLocked() ? clone($item) : $item;
    }

    public function getFirst()
    {
        if(null === $this->first) {
            $msg = 'Could not obtain first item since this collection is empty';
            throw new CollectionException($msg);
        }

        $first = $this->items[$this->first];

        return is_object($first) && $this->_isLocked() ? clone($first) : $first;
    }

    public function getFirstKey()
    {
        return $this->first;
    }

    public function getLast()
    {
        if(null === $this->last) {
            $msg = 'Could not obtain last item since this collection is empty';
            throw new CollectionException($msg);
        }

        $last = $this->items[$this->last];

        return is_object($last) && $this->_isLocked() ? clone($last) : $last;
    }

    public function getLastKey()
    {
        return $this->last;
    }

    public function isEmpty() : bool
    {
        return 0 === $this->count;
    }

    public function hasKey($key) : bool
    {
        return ArrayHelper::hasKey($this->items, $key);
    }

    public function keys() : array
    {
        return array_keys($this->items);
    }

    public function hasValue($value) : bool
    {
        foreach($this as $val){
            if($val === $value){
                return true;
            }
        }

        return false;
    }

    public function map(callable $func) : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = clone($this);
        $map = IterableHelper::map($collection, $func);
        $collection->setItems([]);

        if($collection instanceof AppendableInterface){
            return $collection->appendMany($map);
        }

        $collection->setItems($map);

        return $collection;
    }

    public function filter(callable $func, int $mode=0) : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = clone($this);
        $collection->setItems(IterableHelper::filter($this, $func, $mode));
        return $collection;
    }

    public function implode(string $separator, bool $considerToStringObjects=true) : string
    {
        return implode(
            $this->filter(static function($item) use ($considerToStringObjects){
                if(is_string($item)){
                    return true;
                }

                if(is_numeric($item)){
                    return (string) $item;
                }

                if(
                    $considerToStringObjects &&
                    is_object($item) &&
                    in_array('__toString', get_class_methods($item), true)
                )
                {
                    return true;
                }

                return false;
            })
            ->map(static function ($item){
                return sprintf('%s', $item);
            })
            ->toArray(),
            $separator
        );
    }

    public function toArray(): array
    {
        $isLocked = $this->_isLocked();

        /**
         * If the current class does not implements LockableObjectInterface, modification on it's
         * children is allowed (in a collection which contains or may contain objects for example)
         */
        if(!$isLocked){
            return $this->items;
        }

        /**
         * In the case that the current class implements LockableObjectInterface
         * and being the object in a locked state, we need to clone each object
         * reference so they can not be modified externally.
         */
        $items = [];

        foreach($this as $key => $item){
            $items[$key] = is_object($item) && $isLocked ? clone($item) : $item;
        }

        return $items;
    }

    public function sort(callable $fn) : CollectionInterface
    {
        $items = $this->items;

        if($this->_isLocked()){
            $items = \iterator_to_array($this, true);
        }

        uasort($items, $fn);
        $instance = $this->getEmptyInstance();
        $instance->items = $items;
        return $instance;
    }

    public function ksort(callable $fn) : CollectionInterface
    {
        $items = $this->items;

        if($this->_isLocked()){
            $items = \iterator_to_array($this);
        }

        uksort($items, $fn);
        $instance = $this->getEmptyInstance();
        $instance->items = $items;
        return $instance;
    }

    public function getEmptyInstance(...$params) : CollectionInterface
    {
        return new static(...$params);
    }
    //</editor-fold>


    //<editor-fold desc="Protected methods which are used to manipulate private properties when using this trait">
    protected function setCount(int $count): CollectionInterface
    {
        $this->count = $count;
        return $this;
    }

    /**
     * $this->count is not directly manipulated in this code, it must be done externally!
     */
    protected function setItem($item, $key = null): CollectionInterface
    {
        $key = $key ?? $this->count;
        $this->items[$key] = $item;
        return $this;
    }

    protected function setItems(iterable $items): CollectionInterface
    {
        $this->first = null;
        $this->last = null;

        $this->items = IterableHelper::toArray($items);

        $keys = array_keys($this->items);
        $keyCount = count($keys);
        $this->count = $keyCount;

        if(0 === $keyCount){
            return $this;
        }

        if($keyCount === 1) {
            $this->first = $keys[0];
            $this->last = $this->first;

            return $this;
        }

        $this->first = $keys[0];
        $this->last = $keys[$keyCount-1];

        return $this;
    }

    /**
     * @param $first
     * @return CollectionInterface
     * @throws InvalidKeyException
     */
    protected function setFirstKey($first): CollectionInterface
    {
        if(null !== $first){
            ArrayHelper::validateKey($first);
        }

        $this->first = $first;
        return $this;
    }

    /**
     * @param $last
     * @return CollectionInterface
     * @throws InvalidKeyException
     */
    protected function setLastKey($last): CollectionInterface
    {
        if(null !== $last){
            ArrayHelper::validateKey($last);
        }

        $this->last = $last;
        return $this;
    }

    /**
     * $this->count is not directly manipulated in this code, it must be done externally!
     */
    protected function removeItem($key): CollectionInterface
    {
        unset($this->items[$key]);
        return $this;
    }
    //</editor-fold>

    //<editor-fold desc="\Countable Methods">
    public function count() : int
    {
        return $this->count;
    }
    //</editor-fold>

    //<editor-fold desc="\Iterator Methods">
    public function rewind() : void
    {
        reset($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function next()
    {
        $next = next($this->items);
        return $this->_isLocked() && is_object($next) ? clone($next) : $next;
    }

    public function valid() : bool
    {
        $key = key($this->items);
        return $key !== null && $key !== false;
    }

    public function current()
    {
        $current = current($this->items);
        return $this->_isLocked() && is_object($current) ? clone($current) : $current;
    }
    //<editor-fold>

    //<editor-fold desc="Private methods">
    private function _isLocked() : bool
    {
        if(!$this instanceof LockableObjectInterface){
            return false;
        }

        return $this->isLocked();
    }
    //<editor-fold>
}