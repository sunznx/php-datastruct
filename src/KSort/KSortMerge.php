<?php

namespace DataStruct;

class KSortMerge implements KSortMergeInterface
{
    public $save_file;

    /** @var $fileOperations FileOperation[] */
    private $fileOperations;

    /** @var KSortMergeInterface $heap */
    private $heap;

    public const MAX_VALUE = 0xfffffff;

    public function __construct($paths, HeapInterfaces $heap, $save_file)
    {
        foreach ($paths as $path) {
            $this->fileOperations[] = new FileOperation($path);
        }

        $this->save_file = $save_file;
        if (\file_exists($this->save_file)) {
            \exec("rm {$this->save_file}");
        }
        $this->heap = $heap;
    }

    public function merge()
    {
        $idx = 0;
        $cnt = 0;

        while ($cnt != 0 || $idx < count($this->fileOperations)) {
            if ($idx < \count($this->fileOperations)) {
                if ($this->fileOperations[$idx]->isNotEOF()) {
                    $this->heap->push($this->fileOperations[$idx]->next());
                    $cnt += 1;
                } else {
                    $this->heap->push(static::MAX_VALUE);
                }
                $idx += 1;
            } else {
                $topData = $this->heap->getTopData();
                $topIdx = $this->heap->getTopIdx();
                if ($this->fileOperations[$topIdx]->isEOF()) {
                    $this->heap->modifyTop(static::MAX_VALUE);
                    $cnt -= 1;
                } else {
                    $this->heap->modifyTop($this->fileOperations[$topIdx]->next());
                }
                $this->appendValueToFile($topData);
            }
        }

        foreach ($this->fileOperations as $fileOperation) {
            $fileOperation->close();
        }
    }

    private function appendValueToFile(&$value)
    {

        \file_put_contents($this->save_file, \pack('N', $value), \FILE_APPEND);
    }
}