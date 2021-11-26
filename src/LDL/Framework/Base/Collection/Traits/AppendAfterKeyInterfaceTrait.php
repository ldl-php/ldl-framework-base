<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\AppendAfterKeyInterface;

/**
 * Trait AppendAfterKeyInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see AppendAfterKeyInterface
 */
trait AppendAfterKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;
    use AppendableInterfaceTrait {
        append as _append;
    }

    /**
     * Append an element after a specific key to the collection
     *
     * @param mixed $item
     * @param mixed $afterKey
     * @param mixed $key
     * 
     * @return CollectionInterface
     */
    public function appendAfterKey($item, $afterKey, $key = null): CollectionInterface
    {
        // check if key is valid. throws exception if not valid
        $this->get($afterKey);

        $this->requireImplements([
            AppendAfterKeyInterface::class,
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
            $result[$k] = $v;

            if ($afterKey === $k) {
                $result[$lastKey] = $last;
            }
        }

        $this->setItems($result);

        return $this;
    }
}
