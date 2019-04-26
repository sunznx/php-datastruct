<?php

use DataStruct\SkipList\SkipList;

require_once __DIR__ . '/../../vendor/autoload.php';

$sk = new SkipList(0.5, 3);
$sk->insert(3);
$sk->insert(6);
$sk->insert(7);
$sk->insert(9);
$sk->insert(12);
$sk->insert(19);
$sk->insert(17);
$sk->insert(26);
$sk->insert(21);
$sk->insert(25);
$sk->show();

echo $sk->search(19) ? "found\n" : "not found\n";
echo $sk->search(20) ? "found\n" : "not found\n";

$sk->delete(21);
$sk->delete(25);
$sk->show();