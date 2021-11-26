<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\AppendBeforeKeyInterface;

/**
 * Trait AppendBeforeKeyInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see AppendBeforeKeyInterface
 */
trait AppendBeforeKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;
    use AppendableInterfaceTrait {
        append as _append;
    }

    /**
     * Append an element before a specific key to the collection
     *
     * @param mixed $item
     * @param mixed $beforeKey
     * @param mixed $key
     * 
     * @return CollectionInterface
     */
    public function appendBeforeKey($item, $beforeKey, $key = null): CollectionInterface
    {
        // check if key is valid. throws exception if not valid
        $this->get($beforeKey);

        $this->requireImplements([
            AppendBeforeKeyInterface::class,
            CollectionInterface::class
        ]);

        // append item to the items array
        $this->_append($item, $key);

        //get all items with the keys
        $items = $this->toArray();
        $lastKey = $this->getLastKey(); //Has key already resolved
        $last = array_pop($items);

        $result = [];

        foreach ($items as $k => $v) {
            if ($beforeKey === $k) {
                $result[$lastKey] = $last;
            }

            $result[$k] = $v;
        }

        $this->setItems($result);

        return $this;
    }
}
