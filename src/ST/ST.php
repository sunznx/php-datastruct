<?php

namespace DataStruct;

class ST
{
    protected $arr;
    protected $f;

    public function __construct($arr)
    {
        $this->arr = $arr;
        $this->f = [];
        $this->prework();
    }

    private function prework()
    {
        $n = count($this->arr);

        for ($i = 0; $i < $n; $i++) {
            $this->f[$i][0] = $this->arr[$i];
        }

        $t = (int)(log($n) / log(2));
        for ($j = 1; $j <= $t; $j++) {
            for ($i = 0; $i < $n - (1 << $j) + 1; $i++) {
                $this->f[$i][$j] = max(
                    $this->f[$i][$j - 1],
                    $this->f[$i + (1 << ($j - 1))][$j - 1]
                );
            }
        }
    }

    public function query($l, $r)
    {
        $k = (int)(log($r - $l + 1) / log(2));
        return max(
            $this->f[$l][$k],
            $this->f[$r - (1 << $k) + 1][$k]
        );
    }
}