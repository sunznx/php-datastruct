<?php

namespace DataStruct;

class SkipList
{
    /** @var SkipListNode */
    public $head;

    public $p;
    public $maxLevel;
    public $curLevel;

    public function __construct($p, $maxLevel)
    {
        $this->p = $p;
        $this->maxLevel = $maxLevel;
        $this->curLevel = 0;
        $this->head = new SkipListNode(-1, $maxLevel);
    }

    private function rand()
    {
        return (double)(random_int(0, 100) / 100);
    }

    private function randomLevel()
    {
        $r = $this->rand();
        $level = 1;

        while ($r < $this->p && $level < $this->maxLevel) {
            $level += 1;
            $r = $this->rand();
        }
        return $level;
    }

    /**
     * @return SkipListNode[]
     */
    private function findLevelPrev($data)
    {
        $prev = [];
        $cur = $this->head;
        for ($i = $this->curLevel-1; $i >= 0; $i--) {
            while (!empty($cur->next[$i]) && $data > $cur->next[$i]->data) {
                $cur = $cur->next[$i];
            }
            $prev[$i] = $cur;
        }

        return $prev;
    }

    public function insert($data)
    {
        $prev = $this->findLevelPrev($data);

        $level = $this->randomLevel();
        if ($level > $this->curLevel) {
            for ($i = $this->curLevel; $i < $level; $i++) {
                $prev[$i] = $this->head;
            }
            $this->curLevel = $level;
        }

        $n = new SkipListNode($data, $level);
        for ($i = 0; $i < $level; $i++) {
            $n->next[$i] = $prev[$i]->next[$i];
            $prev[$i]->next[$i] = $n;
        }
    }

    public function show()
    {
        for ($i = 0; $i < $this->curLevel; $i++) {
            echo "level: {$i}: ";
            $cur = $this->head->next[$i];
            while (!empty($cur)) {
                echo  "{$cur->data} ";
                $cur = $cur->next[$i];
            }
            echo PHP_EOL;
        }
    }

    public function search($data)
    {
        $prev = $this->findLevelPrev($data);
        if (!empty($prev[0]->next[0]) && $prev[0]->next[0]->data == $data) {
            return true;
        }
        return false;
    }

    public function delete($data)
    {
        $prev = $this->findLevelPrev($data);
        if (!empty($prev[0]->next[0]) && $prev[0]->next[0]->data == $data) {
            for ($i = $this->curLevel-1; $i >= 0; $i--) {
                if (!empty($prev[$i]->next[$i])) {
                    $prev[$i]->next[$i] = $prev[$i]->next[$i]->next[$i];
                }
            }
        }
    }
}

