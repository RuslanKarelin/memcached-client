<?php

namespace MemcachedClient\lib\Actions;

use MemcachedClient\lib\Connection;
use MemcachedClient\lib\Exceptions\StoreException;

class Getter
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws StoreException
     */
    public function get(string $key)
    {
        $resource = $this->connection->getResource();
        $value = '';
        try {
            fwrite($resource, 'get ' . $key . "\r\n");
            $response = fgets($resource);

            if (!str_starts_with($response, 'VALUE')) {
                throw new StoreException('Get fail, key not exists.', 500);
            } else {
                while ('END' !== trim($response)) {
                    $value = $response;
                    $response = fgets($resource);
                }
            }
        } catch (\Exception $exception) {
            throw new StoreException($exception->getMessage(), 500);
        }

        return unserialize($value);
    }
}