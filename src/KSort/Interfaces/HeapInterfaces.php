<?php

namespace DataStruct;

interface HeapInterfaces
{
    public function getTopData();
    public function getTopIdx();
    public function modifyTop($data);
    public function push($data);
    public function isFull();
}