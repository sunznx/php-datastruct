<?php

namespace DataStruct;

class SkipListNode
{
    public $data;
    public $level;

    /** @var SkipListNode[] */
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