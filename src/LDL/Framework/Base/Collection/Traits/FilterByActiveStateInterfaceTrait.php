<?php declare(strict_types=1);

/**
 * This trait applies the FilterByActiveStateInterface so you can just easily use it in your class.
 * Don't forget to validate the items in your collection against IsActiveInterface
 *
 * @see \LDL\Framework\Base\Contracts\IsActiveInterface
 * @see \LDL\Framework\Base\Collection\Contracts\FilterByActiveStateInterface
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByActiveStateInterface;
use LDL\Framework\Base\Contracts\IsActiveInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait FilterByActiveStateInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByActiveStateInterface methods">
    public function filterByActiveState(): CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByActiveStateInterface::class]);

        return $this->filter(static function($v){
            /**
             * @var IsActiveInterface $v
             */
            return $v->isActive();
        });
    }
    //</editor-fold>
}
