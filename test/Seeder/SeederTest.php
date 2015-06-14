<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 13/6/15
 * Time: 2:15 AM
 */

require_once("../../seeder/Seeder.php");

class SeederTest
{
    private $seeder = null;

    public function __construct()
    {
        $this->seeder = new Seeder();
    }

    public function testGetVarcharReturnValidVarchar()
    {
        $varchar = $this->seeder->getVarchar(15);

        $result = strlen($varchar) == 15 ? 'Success: ' : 'Fail: ';

        echo $result . 'Varchar with 15 characters: ' . $varchar . PHP_EOL;
    }
}

$seederTest = new SeederTest();
$seederTest->testGetVarcharReturnValidVarchar();