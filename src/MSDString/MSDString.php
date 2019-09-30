<?php

namespace DataStruct;

class MSDString
{
    public static function sort($arr)
    {
        $maxRadix = static::getMaxLen($arr);
        static::sortedByRadix($arr, $maxRadix-1, 0, 0, \count($arr) - 1);
        return $arr;
    }

    private static function getMaxLen($arr)
    {
        $maxLen = 1;
        foreach ($arr as $str) {
            $maxLen = max($maxLen, \strlen($str));
        }
        return $maxLen;
    }

    // radix 从 0 开始
    private static function getDigitByRadix($str, $radix)
    {
        return isset($str[$radix]) ? (ord($str[$radix]) - ord('a') + 1) : 0;
    }

    private static function sortedByRadix(&$arr, $maxStep, $step, $l, $r)
    {
        $n = ($r - $l + 1);
        if ($n <= 1 || $step > $maxStep) {
            return;
        }

        $maxRadix = 27;
        $map = \array_fill(0, $maxRadix + 1, 0);
        $aux = \array_fill(0, $n, 0);

        for ($i = $l; $i <= $r; $i++) {
            $digit = static::getDigitByRadix($arr[$i], $step);
            $map[$digit + 1] += 1;
        }

        for ($i = 1; $i < $maxRadix; $i++) {
            $map[$i] += $map[$i - 1];
        }

        for ($i = $l; $i <= $r; $i++) {
            $digit = static::getDigitByRadix($arr[$i], $step);
            $idx = $map[$digit]++;
            $aux[$idx] = $arr[$i];
        }

        for ($i = $l; $i <= $r; $i++) {
            $arr[$i] = $aux[$i - $l];
        }

        $lastCnt = 0;
        for ($i = 0; $i < $maxRadix; $i++) {
            $cnt = $map[$i] - $lastCnt;
            if ($cnt >= 1) {
                static::sortedByRadix($arr, $maxStep, $step+1, $lastCnt, $lastCnt + $cnt - 1);
                $lastCnt += $cnt;
            }
        }
    }
}