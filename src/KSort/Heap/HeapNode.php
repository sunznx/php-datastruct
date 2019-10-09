<?php

namespace DataStruct;

class HeapNode
{
    public $idx;
    public $data;

    public function __construct($data, $idx)
    {
        $this->data = $data;
        $this->idx = $idx;
    }
}