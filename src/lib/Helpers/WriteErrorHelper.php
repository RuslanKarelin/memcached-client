<?php

namespace MemcachedClient\lib\Helpers;

use MemcachedClient\lib\Exceptions\StoreException;

class WriteErrorHelper
{
    /**
     * @throws StoreException
     */
    public static function throwErrorIf(mixed $result): void
    {
        if (is_bool($result)) {
            throw new StoreException('Write error.', 500);
        }
    }
}
