<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DataStruct\LSD\LSD;

$arr = [170, 45, 43, 75, 90, 802, 2, 24, 66];

print_r(LSD::sort($arr));