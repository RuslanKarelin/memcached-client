<?php

use MemcachedClient\MemcashedClient;

require __DIR__ . '/vendor/autoload.php';

$client = new MemcashedClient('localhost', 11211);
$client->set('vvv', 'xyz');
echo $client->get('vvv');
$client->delete('vvv');