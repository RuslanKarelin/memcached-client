<?php

namespace MemcachedClient\lib\Actions;

use Exception;
use MemcachedClient\lib\Connection;
use MemcachedClient\lib\Exceptions\StoreException;

class Remover
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws StoreException
     */
    public function delete(string $key): bool
    {
        $resource = $this->connection->getResource();
        try {
            fwrite($resource, 'delete ' . $key . "\r\n");
            $response = fgets($resource);
            if ('DELETED' !== trim($response)) {
                throw new StoreException('Delete fail, key not exists.', 500);
            }
        } catch (Exception $exception) {
            throw new StoreException($exception->getMessage(), 500);
        }

        return true;
    }
}
