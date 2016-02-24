<?php

namespace AndreasGlaser\Helpers;

/**
 * Class RandomHelper
 *
 * @package AndreasGlaser\Helpers
 * @author  Andreas Glaser
 */
class RandomHelper
{
    /**
     * @return bool
     * @author Andreas Glaser
     */
    public static function trueFalse()
    {
        return rand(0, 1) === 1;
    }
}