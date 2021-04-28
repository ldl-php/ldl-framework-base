<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\SortInterface;

trait SortableScalarTrait
{
    //<editor-fold desc="SortableScalarInterface methods">
    public function sortScalar(string $sort=SortInterface::SORT_ASCENDING): CollectionInterface
    {
        /**
         * @var CollectionInterface $this
         */
        return $this->filter(static function($v){
            return is_scalar($v);
        })
        ->sort(static function($a, $b) use($sort){
            return SortInterface::SORT_ASCENDING === $sort ? $a <=> $b : $b <=> $a;
        });
    }
    //</editor-fold>
}