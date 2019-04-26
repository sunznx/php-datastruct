<?php

namespace DataStruct\SkipList;

class Node
{
    public $data;
    public $level;

    /** @var Node[] */
    public $next = [];

    public function __construct($data, $level)
    {
        $this->data = $data;
        $this->level = $level;
        for ($i = 0; $i < $level; $i++) {
            $this->next[$i] = null;
        }
    }
}