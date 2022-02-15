<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Base\Collection\Contracts\SwappableInterface;

/**
 * Trait SwappableInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 */
trait SwappableInterfaceTrait
{
    use ClassRequirementHelperTrait;


    public function swap(int $from, int $to) : CollectionInterface{
        $this->requireTraits([CollectionInterfaceTrait::class]);
        $this->requireImplements([SwappableInterface::class]);
        $this->setItems(IterableHelper::swap($this, $from, $to));

        return $this;
    }
}