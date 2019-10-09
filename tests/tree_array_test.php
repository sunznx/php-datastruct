<?php

use DataStruct\TreeArray;

require_once __DIR__ . '/../vendor/autoload.php';

$arr = [];
for ($i = 0; $i < 100; $i++) {
    $arr[] = random_int(0, 9999999);
}

$treeArr = new TreeArray($arr);

for ($i = 0; $i < 10000; $i++) {
    $n = random_int(0, 50);
    $old = $treeArr->arr[$n];
    $treeArr->arr[$n] = random_int(0, 9999);
    $treeArr->update($n, $treeArr->arr[$n] - $old);
}

for ($i = 0; $i < 1000; $i++) {
    $l = random_int(0, 20);
    $r = random_int(30, 99);
    $t1 = $treeArr->query($l, $r);
    $t2 = $treeArr->querySimple($l, $r);

    if ($t1 != $t2) {
        echo 'die';die;
    }
}
