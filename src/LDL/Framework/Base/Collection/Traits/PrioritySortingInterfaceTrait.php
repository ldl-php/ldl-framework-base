<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Contracts\PriorityInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\PrioritySortingInterface;

/**
 * Trait PrioritySortingInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see PrioritySortingInterface
 */
trait PrioritySortingInterfaceTrait
{
    use SortInterfaceTrait,
        ClassRequirementHelperTrait;

    //<editor-fold desc="PrioritySortingInterface methods">
    public function sortByPriority(string $sort = Constants::SORT_ASCENDING): CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            PrioritySortingInterface::class
        ]);

        /**
         * @var CollectionInterface $this
         */
        return $this->filter(static function ($v) {
            return $v instanceof PriorityInterface;
        })->sortByCallback(static function ($a, $b) use ($sort) {
            $priorityA = $a->getPriority();
            $priorityB = $b->getPriority();

            return Constants::SORT_ASCENDING === $sort ? $priorityA <=> $priorityB : $priorityB <=> $priorityA;
        });
    }
    //</editor-fold>
}
