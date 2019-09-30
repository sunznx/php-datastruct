<?php

namespace DataStruct;

class TrieNode
{
    public $cnt;

    /** @var TrieNode[] */
    public $children;

    public function __construct()
    {
        $this->cnt = 0;
        $this->children = \array_fill(0, 26, null);
    }

    public function isEmpty()
    {
        foreach ($this->children as $child) {
            if (!empty($child)) {
                return false;
            }
        }
        return true;
    }
}