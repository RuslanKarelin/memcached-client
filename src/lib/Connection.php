<?php

namespace MemcachedClient\lib;

use Exception;
use MemcachedClient\lib\Exceptions\ConnectionException;

class Connection
{
    /**
     * @var false|resource
     */
    private $resource;

    /**
     * @throws ConnectionException
     */
    public function __construct(
        private readonly string $hostname,
        private readonly int $port
    ) {
        $this->resource = fsockopen($this->hostname, $this->port);
        if (!$this->resource) {
            throw new ConnectionException('Connection error', 500);
        }
    }

    /**
     * @return false|resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return void
     */
    public function close(): void
    {
        fclose($this->resource);
    }
}
