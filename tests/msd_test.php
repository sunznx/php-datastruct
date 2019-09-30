<?php

use DataStruct\MSD;
use DataStruct\MSD1;

require_once __DIR__ . '/../vendor/autoload.php';

$arr = [];
for ($i = 0; $i < 100000; $i++) {
    $arr[] = random_int(0, 9999999);
}

sort($arr);