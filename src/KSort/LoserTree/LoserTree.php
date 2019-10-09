<?php

namespace DataStruct;

class LoserTree extends AbstractHeap
{
    public $leaves = [];

    /** @var LoserTreeNode[] */
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
            $this->tree[$i] = new LoserTreeNode($idx, $idx);
        }
        for ($x = $lastNonLeavesIndex; $x >= 0; $x--) {
            $left = $this->tree[$this->left($x)]->winnerIdx;
            $right = $this->tree[$this->right($x)]->winnerIdx;
            if ($this->leaves[$left] < $this->leaves[$right]) {
                $this->tree[$x] = new LoserTreeNode($left, $right);
            } else {
                $this->tree[$x] = new LoserTreeNode($right, $left);
            }
        }
    }

    private function adjust($idx)
    {
        $leavesCount = $this->capacity;
        $nonLeavesCount = $leavesCount - 1;
        $treeIdx = $idx + $nonLeavesCount;
        $this->tree[$treeIdx]->winnerIdx = $idx;
        $this->tree[$treeIdx]->loserIdx = $idx;

        $adjustIdx = $treeIdx;

        do {
            $parent = $this->parent($adjustIdx);
            $winnerIdx = $this->tree[$adjustIdx]->winnerIdx;
            $loserIdx = $this->tree[$parent]->loserIdx;

            if ($this->leaves[$loserIdx] < $this->leaves[$winnerIdx]) {
                [$this->tree[$parent]->winnerIdx, $this->tree[$parent]->loserIdx] = [$loserIdx, $winnerIdx];
            } else {
                [$this->tree[$parent]->winnerIdx, $this->tree[$parent]->loserIdx] = [$winnerIdx, $loserIdx];
            }
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
        return $this->tree[0]->winnerIdx;
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
        $this->leaves[$top->winnerIdx] = $data;
        $this->adjust($top->winnerIdx);
    }
}