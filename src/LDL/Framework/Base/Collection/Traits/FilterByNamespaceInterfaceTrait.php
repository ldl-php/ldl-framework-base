<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByNamespaceInterface;
use LDL\Framework\Base\Contracts\NamespaceInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\RegexHelper;

/**
 * Trait FilterByNamespaceInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see FilterByNamespaceInterface
 */
trait FilterByNamespaceInterfaceTrait
{
    use FilterByNameInterfaceTrait;
    use ClassRequirementHelperTrait;

    //<editor-fold desc="FilterByNamespaceInterface methods">
    public function filterByNamespaceAuto($mixed) : CollectionInterface
    {
        if(is_iterable($mixed)){
            $mixed = IterableHelper::toArray($mixed);
        }

        if(is_array($mixed)){
            return $this->filterByNamespaces($mixed);
        }

        try {
            return $this->filterByNamespaceRegex((string) $mixed);
        }catch(\LogicException $e) {
            return $this->filterByNamespaces([$mixed]);
        }
    }

    public function filterByNamespaces(iterable $namespaces) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByNamespaceInterface::class]);

        $namespaces = IterableHelper::toArray($namespaces);

        return $this->filter(static function($v) use ($namespaces){
            if(!$v instanceof NamespaceInterface){
                return false;
            }

            /**
             * @var NamespaceInterface $v
             */
            return in_array($v->getNamespace(), $namespaces, true);
        });
    }

    public function filterByNamespace(string $namespace) : CollectionInterface
    {
        return $this->filterByNamespaces([$namespace]);
    }

    public function filterByNamespaceRegex(string $regex) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByNamespaceInterface::class]);

        RegexHelper::validate($regex);

        return $this->filter(static function($v) use ($regex){
            if(!$v instanceof NamespaceInterface){
                return false;
            }

            /**
             * @var NamespaceInterface $v
             */
            return (bool) preg_match($regex, $v->getNamespace());
        });
    }

    public function filterByNamespaceAndName(string $namespace, string $name) : CollectionInterface
    {
        $this->requireImplements([CollectionInterface::class, FilterByNamespaceInterface::class]);

        return $this->filter(static function($v) use ($namespace, $name){
            if(!$v instanceof NamespaceInterface){
                return false;
            }

            /**
             * @var NamespaceInterface $v
             */
            return ($namespace === $v->getNamespace() && $v->getName() === $name);
        });
    }
    //</editor-fold>
}
