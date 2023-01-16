<?php

namespace MemcachedClient\lib\Actions;

use MemcachedClient\lib\Connection;
use MemcachedClient\lib\Exceptions\StoreException;
use MemcachedClient\lib\Helpers\WriteErrorHelper;

class Setter
{
    /**
     * @param string $valueString
     * @param int $flag
     * @param int $exptime
     * @return string
     */
    private function getOptionsString(string $valueString, int $flag, int $exptime): string
    {
        return "$flag $exptime " . strlen($valueString);
    }

    /**
     * @param Connection $connection
     */
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws StoreException
     */
    public function set(
        string $key,
        mixed $value,
        int $flag = 0,
        int $exptime = 0
    ): bool {
        $resource = $this->connection->getResource();
        $valueString = serialize($value);
        $options = $this->getOptionsString($valueString, $flag, $exptime);

        $result = fwrite($resource, 'set ' . $key . ' ' . $options . "\r\n");
        WriteErrorHelper::throwErrorIf($result);
        $result = fwrite($resource, $valueString . "\r\n");
        WriteErrorHelper::throwErrorIf($result);
        $response = fgets($resource);
        return trim($response) === 'STORED';
    }
}
