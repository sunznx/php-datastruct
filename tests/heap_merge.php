<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DataStruct\KSort\Heap\Heap;
use DataStruct\KSort\KSortMerge;
const FILES = __DIR__ . "/output/m_*.txt";
const TO_FILE = __DIR__ . "/output/heap.txt";

$start_memo = memory_get_usage();

$paths = glob(FILES);
$m = new KSortMerge($paths, new Heap(\count($paths)), TO_FILE);
$m->merge();

echo memory_get_usage() - $start_memo . PHP_EOL;