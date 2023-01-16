<?php

namespace MemcachedClient\lib\Actions;

use MemcachedClient\lib\Connection;
use MemcachedClient\lib\Exceptions\StoreException;
use MemcachedClient\lib\Helpers\ReadErrorHelper;
use MemcachedClient\lib\Helpers\WriteErrorHelper;

class Getter
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
    public function get(string $key)
    {
        $resource = $this->connection->getResource();
        $value = '';
        $result = fwrite($resource, 'get ' . $key . "\r\n");
        WriteErrorHelper::throwErrorIf($result);
        $response = fgets($resource);
        ReadErrorHelper::throwErrorIf($response);

        if (!str_starts_with($response, 'VALUE')) {
            throw new StoreException('Get fail, key not exists.', 500);
        } else {
            while ('END' !== trim($response)) {
                $value = $response;
                $response = fgets($resource);
                ReadErrorHelper::throwErrorIf($response);
            }
        }
        return unserialize($value);
    }
}
