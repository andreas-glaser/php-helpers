<?php

namespace AndreasGlaser\Helpers;

/**
 * Class RandomHelper
 *
 * @package AndreasGlaser\Helpers
 */
class RandomHelper
{
    /**
     * @return bool
     */
    public static function trueFalse()
    {
        return rand(0, 1) === 1;
    }
}