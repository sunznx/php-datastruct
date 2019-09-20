<?php

namespace DataStruct\MSD;

class MSD
{
    public static function sort($arr)
    {
        $maxRadix = static::getNumCount(max($arr)) - 1;
        return static::sortContainers(self::toContainerByRadix($arr, $maxRadix), $maxRadix);
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

    private static function sortContainers($container, $radix)
    {
        if ($radix == 0) {
            $res = [];
            foreach ($container as $arr) {
                foreach ($arr as $num) {
                    $res[] = $num;
                }
            }
            return $res;
        }

        $res = [];
        foreach ($container as $arr) {
            if (\count($arr) == 0) {
                continue;
            }
            if (\count($arr) == 1) {
                $res[] = $arr[0];
            }
            if (\count($arr) > 1) {
                $sortedArr = self::sortContainers(self::toContainerByRadix($arr, $radix - 1), $radix - 1);
                foreach ($sortedArr as $num) {
                    $res[] = $num;
                }
            }
        }
        return $res;
    }

    private static function toContainerByRadix($arr, $radix)
    {
        $container = \array_fill(0, 10, []);
        foreach ($arr as $num) {
            $digit = static::getDigitByRadix($num, $radix);
            $container[$digit][] = $num;
        }
        return $container;
    }
}