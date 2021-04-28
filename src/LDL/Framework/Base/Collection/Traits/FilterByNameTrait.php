<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Contracts\NameableInterface;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\RegexHelper;

trait FilterByNameTrait
{
    //<editor-fold desc="FilterByNameInterface methods">
    public function filterByNameAuto($mixed) : CollectionInterface
    {
        if(is_array($mixed)){
            return $this->filterByNames($mixed);
        }

        try {
            return $this->filterByNameRegex($mixed);
        }catch(\LogicException $e) {
            return $this->filterByNames([$mixed]);
        }
    }

    public function filterByName(string $name) : CollectionInterface
    {
        return $this->filterByNames([$name]);
    }

    public function filterByNames(iterable $names) : CollectionInterface
    {
        $names = IterableHelper::toArray($names);

        return $this->filter(static function($v) use ($names){
            /**
             * @var NameableInterface $v
             */
            return in_array($v->getName(), $names, true);
        });
    }

    public function filterByNameRegex(string $regex) : CollectionInterface
    {
        RegexHelper::validate($regex);

        return $this->filter(static function($v) use ($regex){
            /**
             * @var NameableInterface $v
             */
            return preg_match($regex, $v->getName());
        });
    }
    //</editor-fold>
}
