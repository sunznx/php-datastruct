<?php

namespace DataStruct\LSD;

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
        $container = \array_fill(0, 10, []);
        foreach ($arr as $num) {
            $digit = static::getDigitByRadix($num, $radix);
            $container[$digit][] = $num;
        }

        $res = [];
        for ($i = 0; $i <= 9; $i++) {
            foreach ($container[$i] as $num) {
                $res[] = $num;
            }
        }
        return $res;
    }
}