<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 14/6/15
 * Time: 12:20 PM
 */

class StopWatch {

    const DEFAULT_NAME = 'default';

    const STATE_NOT_STARTED = 1;
    const STATE_STARTED = 2;
    const STATE_PAUSED = 3;
    const STATE_STOPPED = 4;

    private $watches;
    private $watchStructure = array(
        'state' => StopWatch::STATE_NOT_STARTED,
        'startTime' => null,
        'totalTime' => 0
    );

    public function __construct($watches = array())
    {
        $this->watches = array();

        foreach ($watches as $watch) {
            $this->watches[$watch] = $this->watchStructure;
        }
    }

    public function pauseAll($names)
    {
        if (!is_array($names)) {
            // Validation error, prefer throwing exception.
            return false;
        }

        $pauseTime = microtime(true);

        foreach ($names as $watch) {
            if (!$this->pause($watch, $pauseTime)) {
                return false;
            }
        }

        return true;
    }

    public function getTime($name = StopWatch::DEFAULT_NAME)
    {
        // TODO: Validate, if watch exists and started at least once.
        return $this->watches[$name]['totalTime'] + $this->getTimeSinceLastStart($name);

    }

    public function getTimeSinceLastStart($name = StopWatch::DEFAULT_NAME)
    {
        $currentTime = microtime(true);
        $lastStartTime = $this->watches[$name]['startTime'];

        return is_null($lastStartTime) ? 0 : ($currentTime - $lastStartTime);
    }

    /**
     * Pause a given watch.
     *
     * TODO: Validations needed
     * 1. Does watch exist?
     * 2. Is watch started?
     *
     * @param string $name
     * @param null $pauseTime
     * @return bool Does watch paused successfully?
     */
    public function pause($name = StopWatch::DEFAULT_NAME, $pauseTime = null)
    {
        if (null === $pauseTime) {
            $pauseTime = microtime(true);
        }

        $timeSinceLastStart = $pauseTime - $this->watches[$name]['startTime'];

        $this->watches[$name]['totalTime'] += $timeSinceLastStart;
        $this->watches[$name]['startTime'] = null;
        $this->watches[$name]['state'] = StopWatch::STATE_PAUSED;

        return true;
    }

    public function startMultiple($names)
    {
        if (!is_array($names)) {
            // Validation error, prefer throwing exception.
            return false;
        }

        $startTime = microtime(true);

        foreach($names as $watch) {
            if (!$this->start($watch, $startTime)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $name, default StopWatch::DEFAULT_NAME
     * @param int $startTime, default null.
     * @return bool
     */
    public function start($name = StopWatch::DEFAULT_NAME, $startTime = null)
    {
        if (null === $startTime) {
            $startTime = microTime(true);
        }

        if (!isset($this->watches[$name])) {
            $watch = array(
                'state' => StopWatch::STATE_STARTED,
                'startTime' => $startTime,
                'totalTime' => 0
            );
            $this->watches[$name] = $watch;
        } else {
            $this->watches[$name]['state'] = StopWatch::STATE_STARTED;
            $this->watches[$name]['startTime'] = $startTime;
        }


        return true;
    }
}