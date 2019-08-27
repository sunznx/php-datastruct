<?php

namespace DataStruct\KSort\WinnerTree;

use DataStruct\KSort\Abstracts\AbstractHeap;

class WinnerTree extends AbstractHeap
{
    public $leaves = [];

    /** @var WinnerTreeNode[] */
    public $tree = [];

    private $capacity;
    private $size;
    private $treeSize;

    public const MAX_VALUE = 0xfffffff;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
        $this->treeSize = 2 * $capacity - 1;
        $this->leaves = [];
        $this->size = 0;
    }

    private function build()
    {
        $leavesCount = $this->capacity;
        $nonLeavesCount = $leavesCount - 1;

        $firstNonLeavesIndex = 0;
        $lastNonLeavesIndex = $firstNonLeavesIndex + ($nonLeavesCount - 1);

        $firstLeavesIndex = $lastNonLeavesIndex + 1;
        $lastLeavesIndex = $firstLeavesIndex + ($leavesCount - 1);

        for ($i = $firstLeavesIndex; $i <= $lastLeavesIndex; $i++) {
            $idx = $i - $nonLeavesCount;
            $this->tree[$i] = new WinnerTreeNode($idx);
        }
        for ($x = $lastNonLeavesIndex; $x >= 0; $x--) {
            $left = $this->tree[$this->left($x)]->idx;
            $right = $this->tree[$this->right($x)]->idx;
            if ($this->leaves[$left] < $this->leaves[$right]) {
                $this->tree[$x] = new WinnerTreeNode($left);
            } else {
                $this->tree[$x] = new WinnerTreeNode($right);
            }
        }
    }

    private function adjust($idx)
    {
        $leavesCount = $this->capacity;
        $nonLeavesCount = $leavesCount - 1;
        $treeIdx = $idx + $nonLeavesCount;
        $this->tree[$treeIdx]->idx = $idx;

        $adjustIdx = $treeIdx;

        do {
            $parent = $this->parent($adjustIdx);
            $left = $this->left($parent);
            $right = $this->right($parent);
            if ($this->getDataByIdx($this->tree[$left]->idx) < $this->getDataByIdx($this->tree[$right]->idx)) {
                $minIdx = $left;
            } else {
                $minIdx = $right;
            }
            $this->tree[$parent]->idx = $this->tree[$minIdx]->idx;
            $adjustIdx = $parent;
        } while ($parent != 0);
    }

    public function push($data)
    {
        $this->leaves[$this->size] = $data;
        $this->size += 1;

        if ($this->isFull()) {
            $this->build();
        }
    }

    public function getTopData()
    {
        return $this->getDataByIdx($this->getTopIdx());
    }

    public function getTopIdx()
    {
        return $this->tree[0]->idx;
    }

    public function isFull()
    {
        return $this->capacity == $this->size;
    }

    private function getDataByIdx($idx)
    {
        return $this->leaves[$idx];
    }

    public function modifyTop($data)
    {
        $top = $this->tree[0];
        $this->leaves[$top->idx] = $data;
        $this->adjust($top->idx);
    }
}