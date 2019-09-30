<?php

namespace DataStruct\Abstracts;

use DataStruct\Interfaces\HeapInterfaces;

abstract class AbstractHeap implements HeapInterfaces
{
    protected function left($x): int
    {
        return 2 * $x + 1;
    }

    protected function right($x): int
    {
        return 2 * $x + 2;
    }

    protected function parent($x)
    {
        return (int)(($x - 1) / 2);
    }
}