<?php declare(strict_types=1);
/**
 * The trait will filter a collection containing mixed values by PHP types.
 *
 * @see \LDL\Framework\Base\Collection\Contracts\FilterByValueTypeInterface
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;

trait FilterByValueTypeInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByValueTypeInterface methods">
    public function filterByValueType(string $type): CollectionInterface
    {
        $this->requireTraits([CollectionInterfaceTrait::class]);
        $collection = clone($this);
        $collection->setItems(IterableHelper::filterByValueTypes($this, [$type]));
        return $collection;
    }

    public function filterByValueTypes(iterable $types): CollectionInterface
    {
        $this->requireTraits([CollectionInterfaceTrait::class]);
        $collection = clone($this);
        $collection->setItems(IterableHelper::filterByValueTypes($this, $types));
        return $collection;
    }
    //</editor-fold>
}
