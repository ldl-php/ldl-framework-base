<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait FilterByInterfaceTrait
{
    use ResetCollectionTrait;

    //<editor-fold desc="FilterByInterface methods">
    public function filterByInterface(string $interface) : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = $this->_reset();

        if(false === interface_exists($interface)){
            throw new \InvalidArgumentException("Interface '$interface' does not exists");
        }

        foreach($this as $item){
            if(is_object($item) && $item instanceof $interface){
                $collection->append($item);
            }
        }

        return $collection;
    }
    //</editor-fold>
}