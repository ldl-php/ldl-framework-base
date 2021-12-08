<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\JsonFactoryException;

interface JsonFactoryInterface
{
    /**
     * @param string $json
     * @throws JsonFactoryException
     * @return JsonFactoryInterface
     */
    public static function fromJsonString(string $json) : JsonFactoryInterface;
}
