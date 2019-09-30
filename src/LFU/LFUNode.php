<?php

namespace DataStruct;

class LFUNode
{
    /** @var LFUNode */
    public $prev;

    /** @var LFUNode */
    public $next;

    public $key;

    public $value;

    public function __construct($key = null, $value = null)
    {
        $this->prev = null;
        $this->next = null;
        $this->key = $key;
        $this->value = $value;
    }

    public function isTail()
    {
        return $this->next == null;
    }

    public function isHead()
    {
        return $this->prev == null;
    }
}