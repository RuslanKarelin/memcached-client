<?php

namespace MemcachedClient\lib\Helpers;

use MemcachedClient\lib\Exceptions\StoreException;

class ReadErrorHelper
{
    /**
     * @throws StoreException
     */
    public static function throwErrorIf(mixed $result): void
    {
        if (is_bool($result)) {
            throw new StoreException('Read error.', 500);
        }
    }
}
