<?php

use DataStruct\MSD\MSD;

require_once __DIR__ . '/../vendor/autoload.php';

$arr = [170, 45, 43, 75, 90, 802, 2, 24, 66];
// $arr = [117, 4, 3, 7, 9, 8, 2, 4, 6, 22];

print_r(MSD::sort($arr));