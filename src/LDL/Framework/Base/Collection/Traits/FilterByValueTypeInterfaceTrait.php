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
    public function filterByValueType(string $filter): CollectionInterface
    {
        return $this->filterByValueTypes([$filter]);
    }

    public function filterByValueTypes(iterable $types): CollectionInterface
    {
        $this->requireTraits([CollectionInterfaceTrait::class]);
        $types = IterableHelper::toArray($types);
        return $this->filter(static function ($val, $key) use($types){
           return in_array(gettype($val), $types, true);
        });
    }
    //</editor-fold>
}
