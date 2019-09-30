<?php

use DataStruct\FileOperation;

require_once __DIR__ . '/../vendor/autoload.php';

const FILES = __DIR__ . "/output/m_*.txt";
const TO_FILE = __DIR__ . "/output/simple.txt";

$start_memo = memory_get_usage();

$paths = glob(FILES);

foreach ($paths as $path) {
    $fileOperation = new FileOperation($path);
    while ($fileOperation->isNotEOF()) {
        $data[] = $fileOperation->next();
    }
}
\sort($data);

file_put_contents(TO_FILE, pack('N*', $data));
echo memory_get_usage() - $start_memo . PHP_EOL;