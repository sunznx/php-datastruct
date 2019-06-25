<?php

use DataStruct\LFU\LFUCache;

require_once __DIR__ . '/../../vendor/autoload.php';

$lru = new LFUCache(2);

$lru->put(1, 1);
$lru->put(2, 2);
echo $lru->get(1) . PHP_EOL;       // returns 1
$lru->put(3, 3);    // evicts key 2
echo $lru->get(2) . PHP_EOL;       // returns -1 (not found)
echo $lru->get(3) . PHP_EOL;       // returns 3.
$lru->put(4, 4);    // evicts key 1.
echo $lru->get(1) . PHP_EOL;       // returns -1 (not found)
echo $lru->get(3) . PHP_EOL;       // returns 3
echo $lru->get(4) . PHP_EOL;       // returns 4