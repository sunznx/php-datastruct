<?php

namespace DataStruct\LRU;

class LRUCache
{
    /** @var DoubleLinkList $list */
    private $list;

    private $capacity;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
        $this->list = new DoubleLinkList();
    }

    public function get($key)
    {
        return $this->list->getValue($key);
    }

    public function put($key, $value)
    {
        if ($this->capacity == 0) {
            return;
        }

        if ($this->list->ifKeyExistInList($key)) {
            $this->list->updateValue($key, $value);
        } else {
            if ($this->isFull()) {
                $this->list->removeLastElement();
            }
            $this->list->putValue($key, $value);
        }
    }

    private function isFull()
    {
        return $this->list->size() == $this->capacity;
    }
}
