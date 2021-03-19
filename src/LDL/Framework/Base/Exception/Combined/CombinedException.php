<?php declare(strict_types=1);

namespace LDL\Framework\Base\Exception\Combined;

use LDL\Framework\Base\Collection\Exception\LockAppendException;
use LDL\Framework\Base\Collection\Exception\LockRemoveException;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Exception\LDLException;
use Throwable;

class CombinedException extends LDLException implements CombinedExceptionInterface
{
    use CollectionInterfaceTrait;
    use AppendManyTrait;
    use AppendableInterfaceTrait;
    use RemovableInterfaceTrait;
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
        $this->items = $exceptions;

        $this->_tBeforeAppendCallback = function($collection, $item, $key){
            if(true === $this->isAppendLock()){
                $msg = 'Collection append is locked, can not add elements';

                throw new LockAppendException($msg);
            }

            if(false === is_object($item)){
                $msg = sprintf(
                    'Item must to be an instanceof class: "%s"',
                    \Throwable::class
                );

                throw new \LogicException($msg);
            }

            if(false === $item instanceof \Throwable){
                $msg = sprintf(
                    'Item to be added of class "%s", is not an instanceof class: "%s"',
                    get_class($item),
                    \Throwable::class
                );

                throw new \LogicException($msg);
            }
        };

        $this->_tBeforeRemoveCallback = function($collection, $item, $key){
            if(true === $this->isRemoveLock()){
                $msg = 'Collection remove is locked, can not remove elements';

                throw new LockRemoveException($msg);
            }
        };
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getCombineMessage(string $separator = "\n"): string
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