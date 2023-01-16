<?php

namespace MemcachedClient;

use PHPUnit\Framework\TestCase;
use MemcachedClient\MemcachedClient;

class MemcachedClientTest extends TestCase
{
    protected MemcachedClient $client;

    protected function setUp(): void
    {
        $this->client = new MemcachedClient('localhost', 11211);
    }

    public function testGet()
    {
        $this->client->set('test', 'test value');
        $this->assertEquals('test value', $this->client->get('test'));

        $this->client->set('test', 10);
        $this->assertEquals(10, $this->client->get('test'));

        $this->client->set('test', [10]);
        $this->assertEquals([10], $this->client->get('test'));
    }

    public function testSet()
    {
        $this->assertEquals(true, $this->client->set('test', 'new value'));
        $this->assertEquals('new value', $this->client->get('test'));
    }

    public function testDelete()
    {
        $this->assertEquals(true, $this->client->delete('test'));
    }
}
