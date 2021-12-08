<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\JsonFactoryException;

interface JsonFactoryInterface extends FactoryInterface
{
    /**
     * @param string $json
     * @throws JsonFactoryException
     * @return mixed
     */
    public static function fromJsonString(string $json);
}
