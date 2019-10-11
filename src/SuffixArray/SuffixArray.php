<?php

namespace DataStruct;

class SuffixArray
{
    public $str;
    public $x;
    public $y;
    public $sa;
    public $maxTax;

    public function __construct($str)
    {
        $this->str = $str;
        $this->maxTax = 27;
        $this->prework();
    }

    private function prework()
    {
        $n = \strlen($this->str);
        $this->x = array_fill(0, 2 * $n, 0);
        $this->y = array_fill(0, 2 * $n, 0);
        $this->sa = array_fill(0, $n, 0);

        for ($i = 0; $i < $n; $i++) {
            $this->x[$i] = static::getDigitByRadix($this->str, $i);
        }
        $this->computeSA();
    }

    private function computeSA()
    {
        $n = \strlen($this->str);
        $p = 1;

        while (!$this->isComputeSAok()) {
            for ($i = 0; $i < $n; $i++) {
                $this->y[$i] = $this->x[$i + $p];
            }
            $this->sortByXY();
            $p = $p * 2;
        }

        for ($i = 0; $i < $n; $i++) {
            $this->sa[$i] = $this->x[$i] - 1;
        }
    }

    // radix 从 0 开始
    private static function getDigitByRadix($str, $radix)
    {
        return isset($str[$radix]) ? (ord($str[$radix]) - ord('a') + 1) : 0;
    }

    private function sortByXY()
    {
        $n = \strlen($this->str);
        $taxX = array_fill(0, $this->maxTax + 1, 0);
        $taxY = array_fill(0, $this->maxTax + 1, 0);
        $saY = array_fill(0, $n, 0);
        $saX = array_fill(0, $n, 0);

        for ($i = 0; $i < $n; $i++) {
            $taxY[$this->y[$i] + 1] += 1;
        }

        for ($i = 1; $i < $this->maxTax; $i++) {
            $taxY[$i] += $taxY[$i - 1];
        }

        for ($i = 0; $i < $n; $i++) {
            $digit = $this->y[$i];
            $idx = $taxY[$digit]++;
            $saY[$idx] = $i;
        }

        for ($i = 0; $i < $n; $i++) {
            $taxX[$this->x[$i] + 1] += 1;
        }

        for ($i = 1; $i < $this->maxTax; $i++) {
            $taxX[$i] += $taxX[$i - 1];
        }

        for ($i = 0; $i < $n; $i++) {
            $r = $saY[$i];
            $digit = $this->x[$r];
            $idx = $taxX[$digit]++;
            $saX[$idx] = $r;
        }

        $newX = array_fill(0, 2 * $n, 0);

        $r = 1;
        $newX[$saX[0]] = $r++;

        for ($i = 1; $i < $n; $i++) {
            $curArrIdx = $saX[$i];
            $preArrIdx = $saX[$i - 1];
            if (($this->x[$curArrIdx] == $this->x[$preArrIdx]) && $this->y[$curArrIdx] == $this->y[$preArrIdx]) {
                $newX[$curArrIdx] = $r - 1;
            } else {
                $newX[$curArrIdx] = $r++;
            }
        }

        $this->x = $newX;
    }

    private function isComputeSAok()
    {
        $n = \strlen($this->str);
        $tax = array_fill(0, $this->maxTax + 1, 0);
        for ($i = 0; $i < $n; $i++) {
            $v = $this->x[$i];
            $tax[$v] += 1;
            if ($tax[$v] >= 2) {
                return false;
            }
        }
        return true;
    }
}