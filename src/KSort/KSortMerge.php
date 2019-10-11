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
    public const MIN_VALUE = -0xfffffff;

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
        $n = \count($this->fileOperations);
        $cnt = $n;
        $minValueCnt = $n;
        for ($i = 0; $i < $n; $i++) {
            $this->heap->push(static::MIN_VALUE);
            $this->heap->build();
        }

        while ($cnt > 0) {
            $topData = $this->heap->getTopData();
            $topIdx = $this->heap->getTopIdx();
            if ($this->fileOperations[$topIdx]->isEOF()) {
                $this->heap->modifyTop(static::MAX_VALUE);
                $cnt -= 1;
            } else {
                $this->heap->modifyTop($this->fileOperations[$topIdx]->next());
            }

            if ($minValueCnt > 0) {
                $minValueCnt--;
            } else {
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