<?php

namespace DataStruct;

class RadixTreeNode
{
    public $cnt = 0;
    public $isCompressed = false;
    public $size = 0;

    /** @var string */
    public $data = "";

    /** @var RadixTreeNode[] */
    public $dataPtr = [];

    public function isKey()
    {
        return $this->cnt > 0;
    }

    public function toCompressChildNode($str)
    {
        $this->isCompressed = true;
        $this->size = \strlen($str);
        $this->data = $str;
        $this->dataPtr[0] = new RadixTreeNode(false, 1);
    }

    public function __construct($isCompressed = false, $cnt = 0, $data = "")
    {
        $this->isCompressed = $isCompressed;
        $this->cnt = $cnt;
        $this->data = $data;
        $this->size = \strlen($data);
    }

    public function addNotCompressChildNode($str, $cnt = 0)
    {
        $children = $this->dataPtr[0];
        $children->data .= $str;
        $children->dataPtr[$children->size] = new static(false, $cnt, $str);
        $children->size += 1;
    }

    public function appendNotCompressChildNode($str, $cnt = 0)
    {
        $this->data .= $str;
        $this->dataPtr[$this->size] = new static(false, $cnt);
        $this->size += 1;
    }

    public function matchIdx($str, &$strIdx)
    {
        $strLen = \strlen($str);
        $nodeSize = $this->size;

        if ($this->isCompressed) {
            for ($i = 0; $i < $nodeSize && $strIdx < $strLen; $i++) {
                if ($this->data[$i] != $str[$strIdx]) {
                    return $i - 1;
                }
                $strIdx += 1;
            }
            return $i - 1;
        }

        for ($i = 0; $i < $nodeSize && $strIdx < $strLen; $i++) {
            if ($this->data[$i] == $str[$strIdx]) {
                $strIdx += 1;
                return $i;
            }
        }
        return -1;
    }

    public static function copyCompressNodeData(RadixTreeNode $fromNode, RadixTreeNode $toNode, $from, $to)
    {
        $toNode->dataPtr[0] = $fromNode->dataPtr[0];
        $toNode->data = "";
        for ($i = $from; $i <= $to; $i++) {
            $toNode->data .= $fromNode->data[$i];
        }
        $toNode->size = $to-$from+1;
    }

    /**
     * 将一个 compressNode 缩小到 from ~ to 对应的位置
     */
    public function trimCompressNode($fromPosition, $toPosition, RadixTreeNode $nextNode)
    {
        $data = "";
        $dataPtr[0] = $nextNode;

        for ($i = $fromPosition; $i <= $toPosition; $i++) {
            $data .= $this->data[$i];
        }

        $this->data = $data;
        $this->dataPtr = $dataPtr;
        $this->size = \strlen($this->data);
        $this->isCompressed = $this->size > 1;
    }

    /**
     * 将一个 compressNode 分解成两个 Node
     */
    public function split2Nodes($splitPosition, RadixTreeNode $nextNode)
    {

    }
}