<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Exception\CollectionException;
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
     * Holds a copy of items for iteration
     * @var array
     */
    private $iterationItems = [];

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

    /**
     * @var bool
     */
    private $_inLoop = false;

    /**
     * @var int
     */
    private $iterationCounter = 0;

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

    public function hasKey(
        $key,
        string $operator=Constants::OPERATOR_SEQ,
        string $order=Constants::COMPARE_LTR
    ) : int
    {
        return ArrayHelper::hasKey($this->items, $key, $operator, $order);
    }

    public function keys() : array
    {
        return array_keys($this->items);
    }

    public function hasValue(
        $value,
        string $operator=Constants::OPERATOR_SEQ,
        string $order=Constants::COMPARE_LTR
    ) : int
    {
        return ArrayHelper::hasValue($this->items, $value, $operator, $order);
    }

    public function map(
        callable $func,
        bool $preserveKeys=true,
        int &$mapped=0,
        callable $comparisonFunc = null
    ) : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = clone($this);
        $map = IterableHelper::map($collection, $func, $preserveKeys, $mapped, $comparisonFunc);
        $collection->setItems([]);

        if($collection instanceof AppendableInterface){
            return $collection->appendMany($map);
        }

        $collection->setItems($map);

        return $collection;
    }

    /**
     * @param callable $func
     * @param int $filtered
     * @return CollectionInterface
     */
    public function filter(callable $func, int &$filtered=0) : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = clone($this);
        $collection->setItems(IterableHelper::filter($this, $func, $filtered));
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
                    return true;
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

    public function toArray(bool $useKeys=null) : array
    {
        $useKeys = $useKeys ?? true;

        $isLocked = $this->_isLocked();

        /**
         * If the current class does not implements LockableObjectInterface, modification on it's
         * children is allowed (in a collection which contains or may contain objects for example)
         */
        if(!$isLocked){
            return $useKeys ? $this->items : array_values($this->items);
        }

        /**
         * In the case that the current class implements LockableObjectInterface
         * and being the object in a locked state, we need to clone each object
         * reference so they can not be modified externally.
         */
        $items = [];

        foreach($this->items as $key => $item){
            $value = is_object($item) ? clone($item) : $item;
            $useKeys ? $items[$key] = $value : $items[] = $value;
        }

        return $items;
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
        $this->count = count($this->items);
        return $this;
    }

    protected function setItems(iterable $items): CollectionInterface
    {
        $this->first = null;
        $this->last = null;
        $this->items = IterableHelper::toArray($items, true);

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
        if(!$this->hasKey($key)){
            return $this;
        }

        $this->first = null;
        $this->last = null;

        unset($this->items[$key]);

        $count = $this->count() - 1;
        $count = $count < 0 ? 0 : $count;

        $this->setCount($count);

        $keys = array_keys($this->items);
        $countKeys = count($keys);

        if(0 === $countKeys){
            return $this;
        }

        $this->first =  $keys[0];
        $this->last = $keys[count($keys) - 1];

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

    /**
     * Make a "copy" of the current items in case an internal function which calls setItems
     * is called inside a loop.
     *
     * Background: If the original $this->items variable would be used and there is a modification
     * of the items inside a (for example) a foreach loop through setItems, infinite recursion will occur
     * as the pointer to the original position of the items array is lost.
     *
     * NOTE: As PHP uses a technique called copy on write (CoW), items won't be duplicated unless
     * a modification to said items occurs, this modification is only possible through self::setItems
     * or self::setItem
     *
     * @see self::setItem
     * @see self::setItems
     */
    public function rewind() : void
    {
        $this->iterationItems = $this->items;
    }

    public function valid() : bool
    {
        $key = key($this->iterationItems);
        $valid = $key !== null && $key !== false;
        if(!$valid){
            $this->iterationItems = [];
        }

        return $valid;
    }

    public function current()
    {
        $current = current($this->iterationItems);
        return $this->_isLocked() && is_object($current) ? clone($current) : $current;
    }

    public function key()
    {
        return key($this->iterationItems);
    }

    public function next()
    {
        $next = next($this->iterationItems);
        return $this->_isLocked() && is_object($next) ? clone($next) : $next;
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