<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\KeyResolverInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\ObjectKeyResolverInterface;
use LDL\Framework\Helper\ClassHelper;

class ObjectKeyResolver implements KeyResolverInterface
{
    public function resolve(CollectionInterface $collection, $key, $value=null)
    {
        if(!is_object($key)) {
            return $key;
        }

        if($key instanceof ObjectKeyResolverInterface){
            return $key->getObjectKey();
        }

        if(ClassHelper::hasMethod('__toString', $key)){
            return sprintf('%s', $key);
        }

        throw new \LogicException(
            sprintf(
                'Could not resolve a suitable key for "%s"',
                get_class($key)
            )
        );
    }
}