<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait AppendableInterfaceTrait
{
    /**
     * @var callable|null
     */
    private $_tBeforeAppendCallback;

    //<editor-fold desc="AppendableInterface methods">
    public function onBeforeAppend($item, $key = null): void
    {
        if(null === $this->_tBeforeAppendCallback){
            return;
        }

        ($this->_tBeforeAppendCallback)($this, $item, $key);
    }

    public function append($item, $key = null): CollectionInterface
    {
        $key = $key ?? $this->count;

        $this->onBeforeAppend($item, $key);

        if(null === $this->first){
            $this->first = $key;
        }

        $this->last = $key;

        $this->items[$key] = $item;
        $this->count++;

        return $this;
    }
    //</editor-fold>
}