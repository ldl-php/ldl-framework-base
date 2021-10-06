<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByClassInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByMethodInterface;
use LDL\Framework\Helper\ClassHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

/**
 * Trait FilterByClassInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see FilterByClassInterface
 */
trait FilterByMethodInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByMethodInterface methods">
    public function filterByMethod(string $method) : CollectionInterface
    {
        return $this->filterByMethods([$method]);
    }

    public function filterByMethods(iterable $methods) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByMethodInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        return $this->filter(static function($val) use($methods){
            return ClassHelper::hasMethods(get_class($val), $methods);
        });
    }
    //</editor-fold>
}