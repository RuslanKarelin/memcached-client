<?php

namespace MemcachedClient;

use PHPUnit\Framework\TestCase;
use MemcachedClient\MemcashedClient;

class MemcashedClientTest extends TestCase
{
    protected MemcashedClient $client;

    protected function setUp(): void
    {
        $this->client = new MemcashedClient('localhost', 11211);
    }

    public function testGet()
    {
        $this->client->set('test', 'test value');
        $this->assertEquals('test value', $this->client->get('test'));
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
