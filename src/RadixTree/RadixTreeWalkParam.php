<?php

namespace DataStruct;

class RadixTreeWalkParam
{
    /** @var RadixTreeNode */
    public $matchNode;

    public $matchIdx;
    public $strIdx;

    public function __construct($matchNode, $matchIdx, $strIdx)
    {
        $this->matchNode = $matchNode;
        $this->matchIdx = $matchIdx;
        $this->strIdx = $strIdx;
    }
}