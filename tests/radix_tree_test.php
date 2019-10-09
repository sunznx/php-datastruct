<?php

use DataStruct\RadixTree;

require_once __DIR__ . '/../vendor/autoload.php';

$radix_tree = new RadixTree();
$radix_tree->insert("abceh");
$radix_tree->insert("abcdefgh");
$radix_tree->insert("abcdefgheeee");
$radix_tree->insert("abcdefgheeee");
$radix_tree->insert("c");
$radix_tree->insert("d");
$radix_tree->insert("c");

var_dump($radix_tree->find("abc"));
var_dump($radix_tree->find(""));
var_dump($radix_tree->find("e"));
var_dump($radix_tree->find("c"));
var_dump($radix_tree->find("d"));
var_dump($radix_tree->find("abcdefgheeee"));

print_r($radix_tree->root);