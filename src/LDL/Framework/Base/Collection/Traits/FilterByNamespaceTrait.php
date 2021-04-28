<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Contracts\NamespaceInterface;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\RegexHelper;

trait FilterByNamespaceTrait
{
    use FilterByNameTrait;

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
        $namespaces = IterableHelper::toArray($namespaces);

        return $this->filter(static function($v) use ($namespaces){
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
        RegexHelper::validate($regex);

        return $this->filter(static function($v) use ($regex){
            /**
             * @var NamespaceInterface $v
             */
            return preg_match($regex, $v->getNamespace());
        });
    }

    public function filterByNamespaceAndName(string $namespace, string $name) : CollectionInterface
    {
        return $this->filter(static function($v) use ($namespace, $name){
            /**
             * @var NamespaceInterface $v
             */
            return ($namespace === $v->getNamespace() && $v->getName() === $name);
        });
    }
    //</editor-fold>
}
