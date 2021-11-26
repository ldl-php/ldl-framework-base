<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Helper\RegexHelper;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Base\Exception\LogicException;
use LDL\Framework\Base\Contracts\NameableInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByNameInterface;

/**
 * Trait FilterByNameInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see FilterByNameInterface
 */
trait FilterByNameInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByNameInterface methods">
    public function filterByNameAuto($mixed) : CollectionInterface
    {
        if(is_array($mixed)){
            return $this->filterByNames($mixed);
        }

        try {
            return $this->filterByNameRegex($mixed);
        }catch(LogicException $e) {
            return $this->filterByNames([$mixed]);
        }
    }

    public function filterByName(string $name) : CollectionInterface
    {
        return $this->filterByNames([$name]);
    }

    public function filterByNames(iterable $names) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByNameInterface::class]);

        $names = IterableHelper::toArray($names);

        return $this->filter(static function($v) use ($names){
            if(!$v instanceof NameableInterface){
                return false;
            }

            return in_array($v->getName(), $names, true);
        });
    }

    public function filterByNameRegex(string $regex) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByNameInterface::class]);

        RegexHelper::validate($regex);

        return $this->filter(static function($v) use ($regex){
            if(!$v instanceof NameableInterface){
                return false;
            }

            return (bool) preg_match($regex, $v->getName());
        });
    }
    //</editor-fold>
}
