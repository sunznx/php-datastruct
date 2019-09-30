<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DataStruct\KSortMerge;
use DataStruct\LoserTree\LoserTree;
const FILES = __DIR__ . "/output/m_*.txt";
const TO_FILE = __DIR__ . "/output/loser.txt";

$start_memo = memory_get_usage();

$paths = glob(FILES);
$m = new KSortMerge($paths, new LoserTree(\count($paths)), TO_FILE);
$m->merge();

echo memory_get_usage() - $start_memo . PHP_EOL;