<?php

namespace AndreasGlaser\Helpers;

class TimerHelper
{
    protected static array $timers;

    /**
     * Starts timer.
     */
    public static function start($alias)
    {
        if (isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has already been started.');
        }

        self::$timers[$alias] = microtime();
    }

    /**
     * Gets current time passed since start.
     */
    public static function getDifference($alias): int
    {
        if (!isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has not been started');
        }

        return microtime() - self::$timers[$alias];
    }

    /**
     * Stops/Removes times and returns time passed since start.
     */
    public static function stop(string $alias): int
    {
        if (!isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has not been started');
        }

        $difference = self::getDifference($alias);

        unset(self::$timers[$alias]);

        return $difference;
    }
}
