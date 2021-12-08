<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\JsonFileFactoryException;

interface JsonFileFactoryInterface
{
    /**
     * @param string $file
     * @throws JsonFileFactoryException
     * @return mixed
     */
    public static function fromJsonFile(string $file);
}
