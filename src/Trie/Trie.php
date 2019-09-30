<?php

namespace DataStruct;

class Trie
{
    /** @var TrieNode */
    public $root;

    public function __construct()
    {
        $this->root = new TrieNode();
    }

    public function insert($str)
    {
        $n = \strlen($str);

        $node = $this->root;
        for ($i = 0; $i < $n; $i++) {
            $idx = static::getIdx($str, $i);
            $isLast = (int)($i == $n - 1);
            if (empty($node->children[$idx])) {
                $node->children[$idx] = new TrieNode();
            }
            $node->children[$idx]->cnt += $isLast;
            $node = $node->children[$idx];
        }
    }

    public function find($str)
    {
        $n = \strlen($str);
        $node = $this->root;
        for ($i = 0; $i < $n; $i++) {
            $idx = static::getIdx($str, $i);
            if (empty($node->children[$idx])) {
                return false;
            }
            $node = $node->children[$idx];
        }
        return $node->cnt > 0;
    }

    public function delete($str)
    {
        $this->root = $this->deleteHelper($this->root, $str, 0);
    }

    private function deleteHelper(TrieNode $root, $str, $i)
    {
        $idx = static::getIdx($str, $i);
        $isLast = (int)($i == \strlen($str) - 1);
        if ($isLast) {
            if ($root->children[$i]->isEmpty()) {
                return null;
            } else {
                $root->cnt = 0;
                return $root;
            }
        } else {
            $root->children[$idx] = $this->deleteHelper($root->children[$idx], $str, $i+1);
            return $root;
        }
    }

    public function lazeDelete($str)
    {
        $n = \strlen($str);
        $node = $this->root;
        for ($i = 0; $i < $n; $i++) {
            $idx = static::getIdx($str, $i);
            if (empty($node->children[$idx])) {
                return false;
            }
            $node = $node->children[$idx];
        }
        return $node->cnt = 0;
    }

    private static function getIdx($str, $i)
    {
        return \ord($str[$i]) - \ord('a');
    }
}