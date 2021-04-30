<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait AppendManyTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="AppendableInterface methods">
    public function appendMany(iterable $items, bool $useKey=false) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, AppendableInterface::class]);

        foreach ($items as $key => $value) {
            $this->append($value, $useKey ? $key : null);
        }

        return $this;
    }
    //</editor-fold>
}