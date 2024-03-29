<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\Iterable\Filter\InterfaceFilter;

/**
 * Trait FilterByInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see FilterByInterface
 */
trait FilterByInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByInterface methods">
    public function filterByInterface(string $interface) : CollectionInterface
    {
        return $this->filterByInterfaces([$interface], true);
    }

    public function filterByInterfaces(iterable $interfaces, bool $strict=true) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByInterface::class]);
        $this->requireTraits([CollectionInterfaceTrait::class]);

        $collection = clone($this);

        return $collection->setItems(
            InterfaceFilter::filterByInterfaces(
                $interfaces,
                $collection,
                $strict
            )
        );
    }

    public function filterByInterfaceRecursive(string $interface) : CollectionInterface
    {
        return $this->filterByInterfacesRecursive([$interface]);
    }

    public function filterByInterfacesRecursive(iterable $interfaces) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = clone($this);

        return $collection->setItems(
            InterfaceFilter::filterByInterfacesRecursive(
                $interfaces,
                $collection
            )
        );
    }

    public function filterByInterfaceAndCallMethod(
        string $interface,
        string $method,
        ...$params
    ) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = clone($this);

        return $collection->setItems(
            InterfaceFilter::filterByInterfaceAndCallMethod(
                $interface,
                $collection,
                $method,
                ...$params
            )
        );
    }

    public function filterByInterfaceRecursiveAndCallMethod(
        string $interface,
        string $method,
        ...$params
    ) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        $collection = clone($this);

        return $collection->setItems(
            InterfaceFilter::filterByInterfaceRecursiveAndCallMethod(
                $interface,
                $collection,
                $method,
                ...$params
            )
        );
    }
    //</editor-fold>
}