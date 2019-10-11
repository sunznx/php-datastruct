<?php

namespace DataStruct;

class LSD
{
    public static function sort($arr)
    {
        $times = static::getNumCount(max($arr));
        for ($i = 0; $i < $times; $i++) {
            $arr = static::sortedByRadix($arr, $i);
        }
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

    private static function sortedByRadix($arr, $radix)
    {
        $n = \count($arr);
        $maxRadix = 10;

        $aux = \array_fill(0, $n, 0);
        $map = \array_fill(0, $maxRadix+1, 0);

        foreach ($arr as $num) {
            $digit = static::getDigitByRadix($num, $radix);
            $map[$digit+1] += 1;
        }

        for ($i = 1; $i <= $maxRadix; $i++) {
            $map[$i] += $map[$i-1];
        }

        foreach ($arr as $num) {
            $digit = static::getDigitByRadix($num, $radix);
            $idx = $map[$digit]++;
            $aux[$idx] = $num;
        }
        return $aux;
    }
}