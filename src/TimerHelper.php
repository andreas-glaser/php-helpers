<?php

namespace AndreasGlaser\Helpers;

/**
 * TimerHelper provides utility methods for timing operations.
 * 
 * This class allows you to start, stop, and measure time intervals
 * using named timers. Useful for performance measurement and profiling.
 */
class TimerHelper
{
    /**
     * @var array Stores active timers with their start times
     */
    protected static $timers;

    /**
     * Starts a new timer with the specified alias.
     *
     * @param string $alias The unique identifier for the timer
     *
     * @throws \RuntimeException If a timer with the same alias is already running
     */
    public static function start($alias): void
    {
        if (isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has already been started.');
        }

        self::$timers[$alias] = \microtime(true);
    }

    /**
     * Gets the elapsed time for a running timer.
     *
     * @param string $alias The identifier of the timer to check
     *
     * @return float The elapsed time in seconds
     *
     * @throws \RuntimeException If the specified timer has not been started
     */
    public static function getDifference($alias): float
    {
        if (!isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has not been started');
        }

        return \microtime(true) - self::$timers[$alias];
    }

    /**
     * Stops a timer and returns the elapsed time.
     *
     * @param string $alias The identifier of the timer to stop
     *
     * @return float The elapsed time in seconds
     *
     * @throws \RuntimeException If the specified timer has not been started
     */
    public static function stop($alias): float
    {
        if (!isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has not been started');
        }

        $difference = self::getDifference($alias);

        unset(self::$timers[$alias]);

        return $difference;
    }
}
