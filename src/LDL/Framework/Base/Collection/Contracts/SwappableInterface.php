<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

interface SwappableInterface
{
    /**
     * @param array $item
     * @param int $fromPos
     * @param int $toPos
     */
    public function swap(int $fromPos, int $toPos): CollectionInterface;


}