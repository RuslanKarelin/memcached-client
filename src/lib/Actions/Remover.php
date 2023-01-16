<?php

namespace MemcachedClient\lib\Actions;

use MemcachedClient\lib\Connection;
use MemcachedClient\lib\Exceptions\StoreException;
use MemcachedClient\lib\Helpers\WriteErrorHelper;

class Remover
{
    /**
     * @param Connection $connection
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws StoreException
     */
    public function delete(string $key): bool
    {
        $resource = $this->connection->getResource();
        $result = fwrite($resource, 'delete ' . $key . "\r\n");
        WriteErrorHelper::throwErrorIf($result);
        $response = fgets($resource);
        if ('DELETED' !== trim($response) || is_bool($response)) {
            throw new StoreException('Delete fail, key not exists.', 500);
        }
        return true;
    }
}
