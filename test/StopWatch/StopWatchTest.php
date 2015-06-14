<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 14/6/15
 * Time: 1:08 PM
 */

require_once('../../src/StopWatch/StopWatch.php');

class StopWatchTest {
    private $stopWatch;

    public function __construct()
    {
        $this->stopWatch = new StopWatch();
    }

    public function testTime()
    {
        $this->stopWatch->startMultiple(array('full','exact'));
        sleep(2);
        $this->stopWatch->pause('exact');
        $this->display();
        sleep(1);
        $this->stopWatch->start('exact');
        sleep(3);
        $this->stopWatch->pauseAll(array('full','exact'));
        $this->display();

        //print_r($this->stopWatch);
    }

    public function display()
    {
        echo 'exact took ' . $this->stopWatch->getTime('exact') . ' seconds.' . PHP_EOL;
        echo 'full took ' . $this->stopWatch->getTime('full') . ' seconds.' . PHP_EOL;
    }
}

$stopWatchTest = new StopWatchTest();
$stopWatchTest->testTime();