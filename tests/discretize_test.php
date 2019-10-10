<?php

use DataStruct\Discretize;

require_once __DIR__ . '/../vendor/autoload.php';

$arr = [5, 3, 9999];

$discretize = new Discretize($arr);

$n = count($arr);
for ($i = 0; $i < $n; $i++) {
    $idx = $discretize->getValueIndex($i);
    echo $idx . PHP_EOL;
}




