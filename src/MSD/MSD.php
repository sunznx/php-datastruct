<?php

namespace DataStruct;

class MSD
{
    public static function sort($arr)
    {
        $maxRadix = static::getNumCount(max($arr));
        static::sortedByRadix($arr, $maxRadix - 1, 0, \count($arr) - 1);
        return $arr;
    }

    private static function getNumCount($num)
    {
        $count = 0;
        do {
            $count += 1;
            $num = (int)($num / 10);
        } while ($num != 0);
        return $count;
    }

    // radix 从 0 开始
    private static function getDigitByRadix($num, $radix)
    {
        return ($num / (10 ** $radix)) % 10;
    }

    private static function sortedByRadix(&$arr, $radix, $l, $r)
    {
        $n = ($r - $l + 1);
        if ($n <= 1 || $radix == -1) {
            return;
        }

        $maxRadix = 10;
        $map = \array_fill(0, $maxRadix + 1, 0);
        $aux = \array_fill(0, $n, 0);
        for ($i = $l; $i <= $r; $i++) {
            $digit = static::getDigitByRadix($arr[$i], $radix);
            $map[$digit + 1] += 1;
        }

        for ($i = 1; $i <= $maxRadix; $i++) {
            $map[$i] += $map[$i - 1];
        }

        for ($i = $l; $i <= $r; $i++) {
            $digit = static::getDigitByRadix($arr[$i], $radix);
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
                static::sortedByRadix($arr, $radix - 1, $lastCnt, $lastCnt + $cnt - 1);
                $lastCnt += $cnt;
            }
        }
    }
}