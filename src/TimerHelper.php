<?php

namespace AndreasGlaser\Helpers;

/**
 * Class TimerHelper
 *
 * @package Helpers
 *
 * @author  Andreas Glaser
 */
class TimerHelper
{
    protected static $timers;

    /**
     * Starts timer.
     *
     * @param $alias
     *
     * @throws \RuntimeException
     *
     * @author Andreas Glaser
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
     *
     * @param $alias
     *
     * @return mixed
     * @throws \RuntimeException
     *
     * @author Andreas Glaser
     */
    public static function getDifference($alias)
    {
        if (!isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has not been started');
        }

        return microtime() - self::$timers[$alias];
    }

    /**
     * Stops/Removes times and returns time passed since start.
     *
     * @param $alias
     *
     * @return mixed
     * @throws \RuntimeException
     *
     * @author Andreas Glaser
     */
    public static function stop($alias)
    {
        if (!isset(self::$timers[$alias])) {
            throw new \RuntimeException('Timer has not been started');
        }

        $difference = self::getDifference($alias);

        unset(self::$timers[$alias]);

        return $difference;
    }
}