<?php

namespace MemcachedClient;

use MemcachedClient\lib\Actions\Getter;
use MemcachedClient\lib\Actions\Remover;
use MemcachedClient\lib\Actions\Setter;
use MemcachedClient\lib\Connection;
use MemcachedClient\lib\Exceptions\ConnectionException;
use MemcachedClient\lib\Exceptions\StoreException;

class MemcachedClient
{
    private Connection $connection;
    private Getter $getter;
    private Setter $setter;
    private Remover $remover;

    /**
     * @throws ConnectionException
     */
    public function __construct(
        string $hostname,
        int $port = 11211
    ) {
        $this->connection = new Connection($hostname, $port);
        $this->setter = new Setter($this->connection);
        $this->getter = new Getter($this->connection);
        $this->remover = new Remover($this->connection);
    }

    /**
     * @throws StoreException
     */
    public function get(string $key)
    {
        return $this->getter->get($key);
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
        return $this->setter->set($key, $value, $flag, $exptime);
    }

    /**
     * @throws StoreException
     */
    public function delete(string $key): bool
    {
        return $this->remover->delete($key);
    }

    public function connectionClose()
    {
        $this->connection->close();
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
