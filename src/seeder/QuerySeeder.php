<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 13/6/15
 * Time: 2:27 AM
 */

require_once('Seeder.php');

class QuerySeeder {

    private $query = null;
    private $valueDraft = null;
    private $seeder = null;

    // $query = INSERT INTO tablename (id, col1, col2, col3)
    // $value = array( 'NUL', 'str->25', 'int->0->500', 'dat->Y-m-d h:i:s')

    public function __construct($query, $value)
    {
        $this->query = $query;
        $this->valueDraft = $value;
        $this->seeder = new Seeder();
    }

    public function getQuery($valueSize)
    {
        $valueArray = array();

        for ($i = 0; $i < $valueSize; $i++) {
            $valueArray[] = $this->getValues();
        }

        $query = $this->query . ' VALUES ';
        $queryArray = array();

        foreach ($valueArray as $value) {
            $queryArray[] = '(' . $value . ')' . PHP_EOL;
        }

        return $query . implode(',', $queryArray);
    }

    private function getValues()
    {
        $value = array();

        foreach ($this->valueDraft as $valueDraft) {
            switch (substr($valueDraft, 0, 3)) {
                case 'NUL':
                    $value[] = 'NULL';
                    break;
                case 'str':
                    $value[] = $this->getStringValue($valueDraft);
                    break;
            }
        }

        return implode(',', $value);
    }

    private function getStringValue($signature)
    {
        $signatureArray = explode('->', $signature);

        $string = $this->seeder->getVarchar($signatureArray[1]);

        return "'" . $string . "'";
    }
}