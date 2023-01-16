<?php

namespace MemcachedClient\lib\Actions;

use Exception;
use MemcachedClient\lib\Connection;
use MemcachedClient\lib\Exceptions\StoreException;

class Setter
{
    private function getOptionsString(string $valueString, int $flag, int $exptime): string
    {
        return "$flag $exptime " . strlen($valueString);
    }

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
        try {
            fwrite($resource, 'set ' . $key . ' ' . $options . "\r\n");
            fwrite($resource, $valueString . "\r\n");
            $response = fgets($resource);
        } catch (Exception $exception) {
            throw new StoreException($exception->getMessage(), 500);
        }

        return trim($response) === 'STORED';
    }
}
