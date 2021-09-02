<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\KeyResolverInterface;

class FloatKeyResolver implements KeyResolverInterface
{

    /**
     * @var float
     */
    private $step;

    /**
     * @var float
     */
    private $limit;

    public function __construct(float $step=0.1, float $limit = 100000)
    {
        $this->step = $step;
        $this->limit = $limit;
    }

    public function resolve(CollectionInterface $collection, $key, $value=null)
    {
        $isFloat = is_float($key);

        if(null !== $key && !$isFloat){
            return $key;
        }

        if(!$collection->hasKey((string) $key)){
            return (string) $key;
        }

        $newKey = (float)$key;

        do {
            $newKey += $this->step;

            if($newKey > $this->limit){
                throw new \LogicException("Exceeded new key limit of {$this->limit}");
            }

        } while($collection->hasKey((string)$newKey));

        return (string)$newKey;
    }
}