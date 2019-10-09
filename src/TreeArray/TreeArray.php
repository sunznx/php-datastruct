<?php

namespace DataStruct;

class TreeArray
{
    public $arr;
    public $c;

    public function __construct($arr)
    {
        $n = \count($arr);
        $this->arr = \array_fill(0, $n, 0);
        $this->c = \array_fill(0, $n, 0);

        for ($i = 0; $i < $n; $i++) {
            $this->update($i, $arr[$i]);
        }
    }

    public function update($x, $value)
    {
        $pre = $this->arr[$x];
        $this->arr[$x] = $value;
        $inc = $this->arr[$x] - $pre;
        $n = \count($this->arr);
        while ($x < $n) {
            $this->c[$x] += $inc;
            $len = self::lowbit($x + 1);
            $x = $x + $len;
        }
    }

    public function query($l, $r)
    {
        if ($l == 0) {
            return $this->sumIndex($r);
        }
        return $this->sumIndex($r) - $this->sumIndex($l-1);
    }

    // 下标从 0 开始，x 表示下标，实际区间长度要 +1，计算 lowbit 的时候也要 +1
    // 例如
    // x == 6，区间长度是 7 == 0b111，[7,7], [6, 4], [0, 3]，区间的长度分别是 1, 2, 4
    // x == 5，区间长度是 6 == 0b110，[5, 4], [0, 3]，区间的长度分别是 2, 4
    //
    private function sumIndex($x)
    {
        $sum = 0;
        while ($x >= 0) {
            $r = $x;
            $len = self::lowbit($x + 1);
            $l = $r - $len + 1;

            $sum += $this->c[$x];
            $x = $l - 1;
        }
        return $sum;
    }

    private static function lowbit($x)
    {
        return $x & (-$x);
    }
}