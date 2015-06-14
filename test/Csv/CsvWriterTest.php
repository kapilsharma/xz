<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 14/6/15
 * Time: 3:12 PM
 */

require_once('../../src/Csv/CsvWriter.php');

class CsvWriterTest {
    private $writer;

    public function __construct($filePath, $fileName)
    {
        $this->writer = new CsvWriter($filePath, $fileName, 1000);
    }

    public function writeLine()
    {
        $this->writer->writeLine($this->getCsvHeaders());
    }

    protected function getCsvHeaders()
    {
        return array('id', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6', 'col7', 'col8', 'col9', 'col10',
            'col11', 'col12', 'col13', 'col14', 'col15', 'col16', 'col17', 'col18', 'col19', 'col20',
            'col21', 'col22', 'col23', 'col24', 'col25', 'col26', 'col27', 'col28', 'col29', 'col30',
            'col31', 'col32', 'col33', 'col34', 'col35', 'col36', 'col37', 'col38', 'col39', 'col40',
            'col41', 'col42', 'col43', 'col44', 'col45', 'col46', 'col47', 'col48', 'col49', 'col50',
            'col51', 'col52', 'col53', 'col54', 'col55', 'col56', 'col57', 'col58', 'col59', 'col60',
            'col61', 'col62', 'col63', 'col64', 'col65', 'col66', 'col67', 'col68', 'col69', 'col70',
            'col71', 'col72', 'col73', 'col74', 'col75', 'col76', 'col77', 'col78', 'col79', 'col80',
            'col81', 'col82', 'col83', 'col84', 'col85', 'col86', 'col87', 'col88', 'col89', 'col90',
            'col91', 'col92', 'col93', 'col94', 'col95', 'col96', 'col97', 'col98', 'col99', 'col100');
    }
}
$writer = new CsvWriterTest('/home/kapil/dev/test/xz/csv', 'file500.csv');
$writer->writeLine();