<?php

namespace DataStruct;

class LRUDoubleLinkList
{
    /** @var LRUNode */
    private $head;

    /** @var LRUNode */
    private $tail;

    private $size;

    /** @var LRUNode[] */
    private $map = [];

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

    private function prependNode(LRUNode $node)
    {
        if ($this->head == null) {
            $this->head = $node;
            $this->tail = $node;
        } else {
            $node->next = $this->head;
            $this->head->prev = $node;
            $this->head = $node;
        }
    }

    public function ifKeyExistInList($key)
    {
        return isset($this->map[$key]);
    }

    public function moveKeyToHead($key)
    {
        if ($this->head->key == $key) {
            return;
        }

        $node = $this->map[$key];
        $node->prev->next = $node->next;
        if ($node->next) {
            $node->next->prev = $node->prev;
        } else {
            $this->tail = $node->prev;
        }
        $node->prev = null;
        $node->next = $this->head;
        $this->head->prev = $node;
        $this->head = $node;
    }

    public function updateValue($key, $value)
    {
        $this->map[$key]->value = $value;
        $this->moveKeyToHead($key);
    }

    public function putValue($key, $value)
    {
        $this->map[$key] = new LRUNode($key, $value);
        $this->size += 1;
        $this->prependNode($this->map[$key]);
    }

    public function getValue($key)
    {
        if ($this->ifKeyExistInList($key)) {
            $this->moveKeyToHead($key);
            return $this->map[$key]->value;
        }
        return -1;
    }
}