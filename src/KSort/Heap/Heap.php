<?php

namespace DataStruct\Heap;

use DataStruct\Abstracts\AbstractHeap;

class Heap extends AbstractHeap
{
    /**
     * @var HeapNode[]
     */
    public $nodes;

    private $capacity;
    private $size;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
        $this->size = 0;
        $this->nodes = [];
    }

    private function build()
    {
        for ($x = $this->parent($this->capacity - 1); $x >= 0; $x--) {
            $this->heapify($x);
        }
    }

    private function heapify($x)
    {
        $l = $this->left($x);
        $r = $this->right($x);

        $ori = $x;
        if ($l < $this->capacity && $this->nodes[$l]->data < $this->nodes[$x]->data) {
            $x = $l;
        }
        if ($r < $this->capacity && $this->nodes[$r]->data < $this->nodes[$x]->data) {
            $x = $r;
        }

        if ($ori != $x) {
            $this->swap($x, $ori);
            $this->heapify($x);
        }
    }

    private function swap($i, $j)
    {
        [$this->nodes[$i], $this->nodes[$j]] = [$this->nodes[$j], $this->nodes[$i]];
    }

    public function isFull()
    {
        return $this->size == $this->capacity;
    }

    public function push($data)
    {
        $dataIdx = $this->size;
        $node = new HeapNode($data, $dataIdx);
        $this->nodes[$this->size] = $node;
        $this->size += 1;

        if ($this->isFull()) {
            $this->build();
        }
    }

    public function modifyTop($data)
    {
        $this->nodes[0]->data = $data;
        $this->heapify(0);
    }

    public function getTopData()
    {
        return $this->nodes[0]->data;
    }

    public function getTopIdx()
    {
        return $this->nodes[0]->idx;
    }
}