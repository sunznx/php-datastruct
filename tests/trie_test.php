<?php

use DataStruct\Trie;

require_once __DIR__ . '/../vendor/autoload.php';

$trie = new Trie();
$trie->insert("abc");
// $trie->delete("abc");
// $trie->lazeDelete("abc");
var_dump($trie->find("abc"));
