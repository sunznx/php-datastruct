<?php

namespace DataStruct;

class RadixTree
{
    /** @var RadixTreeNode */
    public $root;

    public function __construct()
    {
        $this->root = new RadixTreeNode();
    }

    public function insert($str)
    {
        $len = \strlen($str);
        $walkParam = $this->raxLowWalk($str);
        $strIdx = $walkParam->strIdx;
        $node = $walkParam->matchNode;
        $splitLen = $walkParam->matchIdx + 1;

        if ($this->walkParamMatchStr($walkParam, $str)) {
            if ($node->isCompressed) {
                $node->dataPtr[0]->cnt += 1;
            } else {
                $node->dataPtr[$walkParam->matchIdx]->cnt += 1;
            }
            return;
        }

        if ($node->isCompressed) {
            if ($strIdx != $len) {
                if ($splitLen == 0) {  // 切割成2块
                    $splitStr = \substr($node->data, 1);
                    $splitNodeIsCompress = \strlen($splitStr) > 1;
                    $splitNodeIsKey = \strlen($splitStr) == 1;
                    $splitNode = new RadixTreeNode($splitNodeIsCompress, (int)$splitNodeIsKey, $splitStr);
                    $splitNode->dataPtr[0] = $node->dataPtr[0];
                    $node->trimCompressNode(0, 0, $splitNode);
                } else {               // 切割成3块
                    $postfixNodeLen = $node->size - 1 - $splitLen;
                    $postfixNodeIsCompressed = $postfixNodeLen > 1;
                    $postfixNode = new RadixTreeNode($postfixNodeIsCompressed, $node->cnt);
                    RadixTreeNode::copyCompressNodeData($node, $postfixNode, $splitLen + 1, $node->size - 1);

                    $splitNode = new RadixTreeNode(false, 0, $node->data[$splitLen]);
                    $splitNode->dataPtr[0] = $postfixNode;
                    $node->trimCompressNode(0, $splitLen - 1, $splitNode);
                    $node = $splitNode;
                }
            } else {
                $postfixNodeLen = $node->size - $splitLen;
                $postfixNodeIsCompressed = $postfixNodeLen > 1;
                $postfixNode = new RadixTreeNode($postfixNodeIsCompressed, $node->cnt);
                RadixTreeNode::copyCompressNodeData($node, $postfixNode, $splitLen, $node->size - 1);
                $node->trimCompressNode(0, $splitLen - 1, $postfixNode);
            }
        }

        while ($strIdx < $len) {
            if ($node->size == 0 && $strIdx + 1 < $len) {
                $compressSize = $len - $strIdx;
                $compressStr = \substr($str, $strIdx, $compressSize);
                $node->toCompressChildNode($compressStr);
                $strIdx += $compressSize;
                $node = $node->dataPtr[0];
            } else {
                $chilrenStr = \substr($str, $strIdx, 1);
                $strIdx += 1;
                $isKey = ($strIdx == $len);
                $node->appendNotCompressChildNode($chilrenStr, (int)$isKey);
                $node = $node->dataPtr[$node->size - 1];
            }
        }
    }

    public function find($str)
    {
        $walkParam = $this->raxLowWalk($str);
        return $this->walkParamMatchStr($walkParam, $str);
    }

    private function walkParamMatchStr(RadixTreeWalkParam $walkParam, $str)
    {
        return $walkParam->matchIdx != -1 && $walkParam->strIdx == \strlen($str) && !empty($walkParam->matchNode) && (
                !$walkParam->matchNode->isCompressed ||
                ($walkParam->matchNode->isCompressed && $walkParam->matchIdx == $walkParam->matchNode->size - 1)
            );
    }

    /**
     * @return RadixTreeWalkParam
     */
    public function raxLowWalk($str)
    {
        $node = $this->root;

        $strLen = \strlen($str);
        $matchIdx = -1;
        $strIdx = 0;
        while (!empty($node)) {
            $matchIdx = $node->matchIdx($str, $strIdx);
            if ($strIdx == $strLen) {
                break;
            }

            if ($matchIdx != -1) {
                if ($node->isCompressed) {
                    if ($matchIdx + 1 == $node->size) {
                        $node = $node->dataPtr[0];
                    } else {
                        break;
                    }
                } else {
                    $node = $node->dataPtr[$matchIdx];
                }
            } else {
                break;
            }
        }
        return new RadixTreeWalkParam($node, $matchIdx, $strIdx);
    }
}