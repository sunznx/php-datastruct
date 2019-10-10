<?php

namespace DataStruct;

class Doublify
{
    protected $arr;
    protected $s;

    public function __construct($arr)
    {
        $this->arr = $arr;
        $this->prework();
    }

    function prework()
    {
        $sum = 0;
        foreach ($this->arr as $i => $num) {
            $sum += $num;
            $this->s[$i] = $sum;
        }
    }

    function query($T)
    {
        $r = count($this->s) - 1;

        $k = 0;
        $p = 1;

        while ($p != 0) {
            if ($k + $p <= $r && $this->s[$k + $p] <= $T) {
                $k = $k + $p;
                $p = $p * 2;
            } else {
                $p = (int)($p / 2);
            }
        }

        return $k;
    }
}

