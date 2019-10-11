<?php

namespace DataStruct;

class Heap extends AbstractHeap
{
    /**
     * @var HeapNode[]
     */
    public $nodes;

    private $size;

    public function __construct()
    {
        $this->size = 0;
        $this->nodes = [];
    }

    public function build()
    {
        for ($x = $this->parent($this->size - 1); $x >= 0; $x--) {
            $this->heapify($x);
        }
    }

    private function heapify($x)
    {
        $l = $this->left($x);
        $r = $this->right($x);

        $ori = $x;
        if ($l < $this->size && $this->nodes[$l]->data < $this->nodes[$x]->data) {
            $x = $l;
        }
        if ($r < $this->size && $this->nodes[$r]->data < $this->nodes[$x]->data) {
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

    public function push($data)
    {
        $dataIdx = $this->size;
        $node = new HeapNode($data, $dataIdx);
        $this->nodes[$this->size] = $node;
        $this->size += 1;
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