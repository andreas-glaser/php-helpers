<?php

namespace AndreasGlaser\Helpers\Color;

/**
 * Class HexHelper
 * 
 * Helper class for working with hexadecimal color codes.
 * Provides methods for color manipulation and conversion.
 */
class HexHelper
{
    /**
     * Adjusts the brightness of a hexadecimal color code
     * 
     * @param string $hex   The hexadecimal color code (e.g. '#FF0000' or '#F00')
     * @param int    $steps The number of steps to adjust brightness (-255 to 255)
     *                      Negative values make the color darker, positive values make it lighter
     * 
     * @return string The adjusted color in hexadecimal format (e.g. '#FF0000')
     */
    public static function adjustBrightness($hex, $steps)
    {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = \max(-255, \min(255, $steps));

        // Normalize into a six character long hex string
        $hex = \str_replace('#', '', $hex);
        if (3 == \strlen($hex)) {
            $hex = \str_repeat(\substr($hex, 0, 1), 2) . \str_repeat(\substr($hex, 1, 1), 2) . \str_repeat(\substr($hex, 2, 1), 2);
        }

        // Split into three parts: R, G and B
        $color_parts = \str_split($hex, 2);
        $return = '#';

        foreach ($color_parts as $color) {
            $color = \hexdec($color); // Convert to decimal
            $color = \max(0, \min(255, $color + $steps)); // Adjust color
            $return .= \str_pad(\dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }

        return $return;
    }
}
