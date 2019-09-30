<?php

namespace DataStruct;

class FileOperation
{
    private $fp;
    private $file;
    private $seek;
    private $end;

    public static $readCount = 0;

    public function __construct($file)
    {
        $this->file = $file;
        $this->fp = \fopen($this->file, 'rb');

        \fseek($this->fp, 0, \SEEK_END);
        $this->end = \ftell($this->fp);

        \fseek($this->fp, 0, \SEEK_SET);
    }

    private function read($size)
    {
        \fseek($this->fp, $this->seek);
        $data = \fread($this->fp, $size);
        $this->seek += $size;
        return \unpack('N', $data)[1];
    }

    public function next()
    {
        return $this->read(4);
    }

    public function isEOF()
    {
        return $this->end <= $this->seek;
    }

    public function isNotEOF()
    {
        return !$this->isEOF();
    }

    public function close()
    {
        fclose($this->fp);
    }
}
