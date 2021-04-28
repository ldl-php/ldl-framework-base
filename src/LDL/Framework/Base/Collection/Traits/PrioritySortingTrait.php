<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\SortInterface;
use LDL\Framework\Base\Contracts\PriorityInterface;

trait PrioritySortingTrait
{
    //<editor-fold desc="PrioritySortingInterface methods">
    public function sortByPriority(string $sort=SortInterface::SORT_ASCENDING): CollectionInterface
    {
        /**
         * @var CollectionInterface $this
         */
        return $this->filter(static function($v){
            return $v instanceof PriorityInterface;
        })
        ->sort(static function($a, $b) use($sort){
            $priorityA = $a->getPriority();
            $priorityB = $b->getPriority();

            return SortInterface::SORT_ASCENDING === $sort ? $priorityA <=> $priorityB : $priorityB <=> $priorityA;
        });
    }
    //</editor-fold>
}