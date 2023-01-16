<?php

namespace MemcachedClient\lib;

use Exception;
use MemcachedClient\lib\Exceptions\ConnectionException;

class Connection
{
    private $resource;

    /**
     * @throws ConnectionException
     */
    public function __construct(
        private readonly string $hostname,
        private readonly int $port
    ) {
        try {
            $this->resource = fsockopen($this->hostname, $this->port);
        } catch (Exception $exception) {
            throw new ConnectionException($exception->getMessage(), 500);
        }
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function close(): void
    {
        fclose($this->resource);
    }
}
