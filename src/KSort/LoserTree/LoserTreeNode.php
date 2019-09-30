<?php

namespace DataStruct\LoserTree;

class LoserTreeNode
{
    public $winnerIdx;
    public $loserIdx;

    public function __construct($winnerIdx, $loserIdx)
    {
        $this->winnerIdx = $winnerIdx;
        $this->loserIdx = $loserIdx;
    }
}