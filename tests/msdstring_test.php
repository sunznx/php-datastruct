<?php

use DataStruct\MSDString;

require_once __DIR__ . '/../vendor/autoload.php';

// $arr = [];
// $cnt = 500000;
// while ($cnt--) {
//     $str = "";
//     $n = random_int(0, 1);
//     for ($i = 0; $i < $n; $i++) {
//         $str .= chr(random_int(0, 25) + ord('a'));
//     }
//     $arr[] = $str;
// }
//
// MSDString::sort($arr);
// sort($arr);

// foreach ($arr as $str) {
//     echo "{$str}" . PHP_EOL;
// }


$arr = ["abc", "def", "a", "d", "z", "za", "z"];
$arr = MSDString::sort($arr);
print_r($arr);