<?php

namespace DataStruct;

class LFUDoubleLinkList
{
    /** @var LFUNode */
    private $head;

    /** @var LFUNode */
    private $tail;

    private $size;

    /** @var LFUNode[] */
    private $map = [];

    private $freq = [];

    public function __construct()
    {
        $this->head = null;
        $this->tail = null;
        $this->size = 0;
    }

    public function size()
    {
        return $this->size;
    }

    public function removeLastElement()
    {
        unset($this->freq[$this->tail->key]);
        unset($this->map[$this->tail->key]);
        if ($this->head->isTail()) {
            $this->head = null;
            $this->tail = null;
        } else {
            $this->tail = $this->tail->prev;
            $this->tail->next = null;
        }
        $this->size -= 1;
    }

    private function appendNode(Node $node)
    {
        if ($this->head == null) {
            $this->head = $node;
            $this->tail = $node;
        } else {
            $this->tail->next = $node;
            $node->prev = $this->tail;
            $this->tail = $node;
        }
    }

    public function ifKeyExistInList($key)
    {
        return isset($this->map[$key]);
    }

    public function updatePositionByFreq($key)
    {
        if ($this->head->key == $key) {
            return;
        }

        $node = $this->map[$key];
        $prev = $node->prev;
        if ($this->freq[$node->key] < $this->freq[$prev->key]) {
            return;
        }
        while ($prev && $this->freq[$node->key] >= $this->freq[$prev->key]) {
            $prev = $prev->prev;
        }

        $node->prev->next = $node->next;
        if ($node->next) {
            $node->next->prev = $node->prev;
        } else {
            if ($node->isTail()) {
                $this->tail = $node->prev;
            }
        }

        $node->prev = $prev;
        if ($prev == null) {
            $node->next = $this->head;
            $this->head->prev = $node;
            $this->head = $node;
        } else {
            $node->next = $prev->next;
            if ($prev->next) {
                $prev->next->prev = $node;
            }
            $prev->next = $node;
        }
    }

    public function updateValue($key, $value)
    {
        $this->map[$key]->value = $value;
        $this->freq[$key] += 1;
        $this->updatePositionByFreq($key);
    }

    public function putValue($key, $value)
    {
        $this->freq[$key] = 1;
        $this->map[$key] = new Node($key, $value);
        $this->size += 1;
        $this->appendNode($this->map[$key]);
        $this->updatePositionByFreq($key);
    }

    public function getValue($key)
    {
        if ($this->ifKeyExistInList($key)) {
            $this->freq[$key] += 1;
            $this->updatePositionByFreq($key);
            return $this->map[$key]->value;
        }
        return -1;
    }
}