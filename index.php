<?php

use MemcachedClient\MemcachedClient;

require __DIR__ . '/vendor/autoload.php';

$client = new MemcachedClient('localhost', 11211);
$client->set('vvv', 'xyz');
echo $client->get('vvv');
$client->delete('vvv');
