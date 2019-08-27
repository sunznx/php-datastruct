<?php

namespace DataStruct\Test;

use DataStruct\KSort\FileOperation;
use PHPUnit\Framework\TestCase;

class KSortTest extends TestCase
{
    private const FILES = __DIR__ . "/output/m_*.txt";
    private const SIMPLE_FILE = __DIR__ . "/output/simple.txt";
    private const HEAP_FILE = __DIR__ . "/output/heap.txt";
    private const WINNER_FILE = __DIR__ . "/output/winner.txt";
    private const LOSER_FILE = __DIR__ . "/output/loser.txt";

    public function setUp()
    {
    }

    public function test_readAll()
    {
        $paths = glob(static::FILES);

        /** @var FileOperation[] $files */
        $files = [];
        foreach ($paths as $k => $path) {
            $files[] = new FileOperation($path);
        }

        $total = 0;
        $max = null;
        $min = null;
        foreach ($files as $k => $fileOperation) {
            $data = [];
            while ($fileOperation->isNotEOF()) {
                $data[] = $fileOperation->next();
            }
            $total += count($data);

            $min = ($min === null ? $data[0] : min($min, $data[0]));
            $max = ($max === null ? end($data) : max($max, end($data)));
        }

        echo "total = {$total}" . PHP_EOL;
        echo "min = {$min}" . PHP_EOL;
        echo "max = {$max}" . PHP_EOL;
    }

    private function sumary($file)
    {
        $fileOperation = new FileOperation($file);
        while ($fileOperation->isNotEOF()) {
            $data[] = $fileOperation->next();
        }
        $total = \count($data);
        $min = $data[0];
        $max = \end($data);

        echo "total = {$total}" . PHP_EOL;
        echo "min = {$min}" . PHP_EOL;
        echo "max = {$max}" . PHP_EOL;
    }

    public function test_simpleSumary()
    {
        $this->sumary(static::SIMPLE_FILE);
        $this->assertTrue(true);
    }

    public function test_heapSumary()
    {
        $this->sumary(static::HEAP_FILE);
        $this->assertTrue(true);
    }

    public function test_winnerSumary()
    {
        $this->sumary(static::WINNER_FILE);
        $this->assertTrue(true);
    }

    public function test_loserSumary()
    {
        $this->sumary(static::LOSER_FILE);
        $this->assertTrue(true);
    }
}