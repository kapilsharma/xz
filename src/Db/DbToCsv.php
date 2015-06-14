<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 14/6/15
 * Time: 3:52 PM
 */

require_once('../Csv/CsvWriter.php');
require_once('../StopWatch/StopWatch.php');

class DbToCsv {

    /**
     * @var PDO Pdo class
     */
    private $connection;

    /**
     * @var PDOStatement
     */
    private $statement;

    private $host;
    private $dbName;
    private $dbUsername;
    private $dbPassword;

    public function __construct($host, $dbName, $dbUsername, $dbPassword)
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
    }

    public function connect()
    {
        $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName,
                $this->dbUsername, $this->dbPassword);
    }

    public function prepareQuery($table)
    {

        $query = 'SELECT * ' .
                'FROM ' . $table .
                ' ORDER BY id ' .
                'LIMIT :start , :end';

        $this->statement = $this->connection->prepare($query);
    }

    public function getRecords($start = 0, $end = 100)
    {
        $this->statement->bindValue(':start', $start, PDO::PARAM_INT);
        $this->statement->bindValue(':end', $end, PDO::PARAM_INT);
        $this->statement->execute();

        return $this->statement->fetchAll(PDO::FETCH_NUM);
    }

    public function getCount($table)
    {
        $statement = $this->connection->query('SELECT COUNT(*) FROM ' . $table);
        $result = $statement->fetch(PDO::FETCH_NUM);

        return $result[0];
    }

}

$tableName = 'test500000';
$batch = 5000;

$writer = new CsvWriter('/home/kapil/dev/test/xz/csv', 'file500000.csv', 1000);
$header = array('id', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6', 'col7', 'col8', 'col9', 'col10',
    'col11', 'col12', 'col13', 'col14', 'col15', 'col16', 'col17', 'col18', 'col19', 'col20',
    'col21', 'col22', 'col23', 'col24', 'col25', 'col26', 'col27', 'col28', 'col29', 'col30',
    'col31', 'col32', 'col33', 'col34', 'col35', 'col36', 'col37', 'col38', 'col39', 'col40',
    'col41', 'col42', 'col43', 'col44', 'col45', 'col46', 'col47', 'col48', 'col49', 'col50',
    'col51', 'col52', 'col53', 'col54', 'col55', 'col56', 'col57', 'col58', 'col59', 'col60',
    'col61', 'col62', 'col63', 'col64', 'col65', 'col66', 'col67', 'col68', 'col69', 'col70',
    'col71', 'col72', 'col73', 'col74', 'col75', 'col76', 'col77', 'col78', 'col79', 'col80',
    'col81', 'col82', 'col83', 'col84', 'col85', 'col86', 'col87', 'col88', 'col89', 'col90',
    'col91', 'col92', 'col93', 'col94', 'col95', 'col96', 'col97', 'col98', 'col99', 'col100');
$writer->writeLine($header);

echo 'Working on \'' . $tableName . '\' table' . PHP_EOL;

$stopWatch = new StopWatch();
$watches = array('total', 'getCount');

echo 'Starting watches: total and getCount' . PHP_EOL;
$stopWatch->startMultiple($watches);

echo 'Getting total rows.' . PHP_EOL;
$dbToCsv = new DbToCsv('localhost', 'xztest', 'root', 'rootpw');
$dbToCsv->connect();
$rowCount = $dbToCsv->getCount($tableName);

$stopWatch->pause('getCount');
echo 'Row count took ' . $stopWatch->getTime('getCount') . ' seconds. Total rows: ' . $rowCount . PHP_EOL;

echo 'Starting \'prepare\' watch.' . PHP_EOL;
$stopWatch->start('prepare');
$dbToCsv->prepareQuery($tableName);
$stopWatch->pause('prepare');
echo '\'Prepare\' took ' . $stopWatch->getTime('prepare') . ' seconds.' . PHP_EOL;

echo 'Starting loop' . PHP_EOL;
$stopWatch->start('loop');
$j = 1;
for ($i = 0; $i < $rowCount; $i += $batch) {
    echo 'Starting loop' . $j . PHP_EOL;
    $stopWatch->start('loop' . $j);

    $result = $dbToCsv->getRecords($i, $batch);

    foreach($result as $row) {
        $writer->writeLine($row);
    }

    $stopWatch->pause('loop' . $j);
    echo 'Ending loop' . $j . '. Took ' . $stopWatch->getTime('loop' . $j) . ' seconds.' . PHP_EOL;
    $j++;
}
$stopWatch->pause('loop');
echo 'loop ends. It took ' . $stopWatch->getTime('loop') . ' seconds.' . PHP_EOL;

$stopWatch->pause('total');
echo 'Ending total. Full script took ' . $stopWatch->getTime('total') . ' seconds.' . PHP_EOL;