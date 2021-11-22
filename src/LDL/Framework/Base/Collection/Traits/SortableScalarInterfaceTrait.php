<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\SortableScalarInterface;

/**
 * Trait SortableScalarInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see SortableScalarInterface
 */
trait SortableScalarInterfaceTrait
{
    use SortInterfaceTrait,
        ClassRequirementHelperTrait;

    //<editor-fold desc="SortableScalarInterface methods">
    public function sortScalar(string $sort = Constants::SORT_ASCENDING): CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            SortableScalarInterface::class
        ]);

        /**
         * @var CollectionInterface $this
         */
        return $this->filter(static function ($v) {
            return is_scalar($v);
        })->sortByCallback(static function ($a, $b) use ($sort) {
            return Constants::SORT_ASCENDING === $sort ? $a <=> $b : $b <=> $a;
        });
    }
    //</editor-fold>
}