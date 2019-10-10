<?php

namespace DataStruct;

class Discretize
{
    public $arr;

    /** @var DiscretizeStuff[] */
    public $stuffs;
    public $ranks;

    public function __construct($arr)
    {
        $this->arr = $arr;
        foreach ($arr as $index => $data) {
            $this->stuffs[$index] = new DiscretizeStuff($index, $data);
        }

        static::sortStuff($this->stuffs);

        foreach ($this->stuffs as $k => $stuff) {
            $this->ranks[$stuff->index] = $k;
        }
    }

    public function getValueIndex($keyIndex)
    {
        return $this->ranks[$keyIndex];
    }

    /**
     * @param $stuffs DiscretizeStuff[]
     */
    private static function sortStuff(&$stuffs)
    {
        \usort($stuffs, function (DiscretizeStuff $a, DiscretizeStuff $b) {
            return $a->data > $b->data;
        });
    }
}