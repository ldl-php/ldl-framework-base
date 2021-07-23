<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

trait ClassRequirementHelperTrait
{
    private $_tVerifyCollectionTraitHelperHasTraits = [];
    private $_tVerifyCollectionTraitHelperHasInterfaces = [];

    /**
     * Thanks to Saif Eddin Gmati for the naming idea
     *
     * @param string|iterable $traits
     * @param string|null $class
     * @throws \RuntimeException
     */
    protected function requireTraits($traits, string $class=null): void
    {
        $class = $class ?? get_class($this);
        $traits = is_string($traits) ? [$traits] : IterableHelper::toArray($traits);

        /**
         * No differences
         */
        if($this->_tVerifyCollectionTraitHelperHasTraits === $traits){
            return;
        }

        $traits = array_filter($traits, function ($trait){
            return !in_array($trait, $this->_tVerifyCollectionTraitHelperHasTraits,true);
        });

        if(count($traits) === 0){
            return;
        }

        ClassHelper::mustHaveTraits($class, $traits);

        $this->_tVerifyCollectionTraitHelperHasTraits = array_merge($this->_tVerifyCollectionTraitHelperHasTraits, $traits);
    }

    /**
     * Thanks to Saif Eddin Gmati for the naming idea
     *
     * @param string|iterable $interfaces
     * @param string|null $class
     * @throws \RuntimeException
     */
    protected function requireImplements($interfaces, string $class=null) : void
    {
        $class = $class ?? get_class($this);
        $interfaces = is_string($interfaces) ? [$interfaces] : IterableHelper::toArray($interfaces);

        /**
         * No differences
         */
        if($this->_tVerifyCollectionTraitHelperHasInterfaces === $interfaces){
            return;
        }

        $interfaces = array_filter($interfaces, function ($interface){
            return !in_array($interface, $this->_tVerifyCollectionTraitHelperHasInterfaces,true);
        });

        if(count($interfaces) === 0){
            return;
        }

        ClassHelper::mustHaveInterfaces($class, $interfaces);

        $this->_tVerifyCollectionTraitHelperHasInterfaces = array_merge(
            $this->_tVerifyCollectionTraitHelperHasInterfaces,
            $interfaces
        );
    }
}