<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByClassInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\Iterable\Filter\ClassFilter;

trait FilterByClassInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByClassInterface methods">
    public function filterByClass(string $class, bool $strict=true) : CollectionInterface
    {
        return $this->filterByClasses([$class], $strict);
    }

    public function filterByClasses(iterable $classes, bool $strict=true) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByClassInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);
        $collection = clone($this);

        return $collection->setItems(
            ClassFilter::filterByClasses(
                $classes,
                $collection,
                $strict
            )
        );
    }

    public function filterByClassRecursive(string $className) : CollectionInterface
    {
        return $this->filterByClassesRecursive([$className]);
    }

    public function filterByClassesRecursive(iterable $classes) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByClassInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = clone($this);

        return $collection->setItems(
          ClassFilter::filterByClassesRecursive($classes, $collection)
        );
    }

    public function filterByClassAndCallMethod(
        string $class,
        string $method,
        ...$params
    ) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByClassInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = clone($this);

        return $collection->setItems(
            ClassFilter::filterByClassAndCallMethod(
                $class,
                $collection,
                $method,
                ...$params
            )
        );
    }

    public function filterByClassRecursiveAndCallMethod(
        string $class,
        string $method,
        ...$params
    ) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByClassInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = clone($this);

        return $collection->setItems(
            ClassFilter::filterByClassRecursiveAndCallMethod(
                $class,
                $collection,
                $method,
                ...$params
            )
        );
    }

    //</editor-fold>
}