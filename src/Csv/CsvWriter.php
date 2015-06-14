<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 14/6/15
 * Time: 2:36 PM
 */

class CsvWriter {

    const TOTAL_LINE = 100000;

    const FILE_MODE_APPEND = 'a';

    private $totalLines;
    private $fileName;
    private $fileHandle;

    public function __construct($filePath, $fileName, $totalLine = null)
    {
        //if (!is_writeable($filePath)) {
            //die('File path not writable' . PHP_EOL);
        //}

        $this->fileName = $filePath . DIRECTORY_SEPARATOR . $fileName;

        if (null === $totalLine) {
            $totalLine = CsvWriter::TOTAL_LINE;
        }

        $this->totalLines = $totalLine;
        $this->openFile();
    }

    public function writeLine($lineArray)
    {
        fputcsv($this->fileHandle, $lineArray);
    }

    protected function openFile($mode = CsvWriter::FILE_MODE_APPEND)
    {
        $this->fileHandle = fopen($this->fileName, $mode);
    }

}