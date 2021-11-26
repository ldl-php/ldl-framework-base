<?php declare(strict_types=1);

namespace LDL\Framework\Base\Exception\Combined;

use Throwable;
use LDL\Framework\Base\Exception\LDLException;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Exception\InvalidArgumentException;
use LDL\Framework\Base\Collection\Exception\LockAppendException;
use LDL\Framework\Base\Collection\Exception\LockRemoveException;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\BeforeAppendInterfaceTrait;

class CombinedException extends LDLException implements CombinedExceptionInterface
{
    use CollectionInterfaceTrait;
    use BeforeAppendInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemoveByKeyInterfaceTrait;
    use LockAppendInterfaceTrait;
    use LockRemoveInterfaceTrait;

    public function __construct(
        string $message = "",
        int $code = 0,
        Throwable $previous = null,
        iterable $exceptions = null
    )
    {
        parent::__construct($message, $code, $previous);

        $this->getBeforeAppend()->append(static function($collection, $item, $key){
            if(false === is_object($item)){
                throw new InvalidArgumentException('Item to be added is not an object');
            }

            if($item instanceof \Throwable){
                return;
            }

            $msg = sprintf(
                'Item to be added is not an instanceof class: "%s", class: "%s" was given',
                \Throwable::class,
                get_class($item)
            );

            throw new InvalidArgumentException($msg);
        });

        if(null !== $exceptions){
            $this->appendMany($exceptions);
        }
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getCombinedMessage(string $separator = "\n"): string
    {
        $buffer = [];

        /**
         * @var \Exception $exception
         */
        foreach($this->items as $exception){
            $buffer[] = $exception->getMessage();
        }

        return implode($separator, $buffer);
    }
}