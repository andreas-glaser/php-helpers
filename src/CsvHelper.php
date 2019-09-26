<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Validate\IOExpect;

/**
 * Class CsvHelper
 *
 * @package AndreasGlaser\Helpers
 */
class CsvHelper
{

    /**
     * @param string $file
     * @param bool   $isFirstLineTitle
     * @param int    $length
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     *
     * @return array
     */
    public static function fileToArray(string $file, bool $isFirstLineTitle = false, int $length = 0, string $delimiter = ',', string $enclosure = '"', string $escape = "\\"): array
    {
        IOExpect::isFile($file);
        IOExpect::isReadable($file);

        $result = [];
        $titles = [];
        $hasTitles = false;
        $rowNumber = 0;

        $handle = fopen($file, 'r');

        while (($row = fgetcsv($handle, $length, $delimiter, $enclosure, $escape)) !== false) {

            if ($isFirstLineTitle === true && $hasTitles === false) {
                foreach ($row AS $index => $title) {
                    $titles[$index] = $title;
                }
                $hasTitles = true;
                continue;
            }

            $result[$rowNumber] = [];

            foreach ($row AS $index => $cell) {

                if ($isFirstLineTitle === true) {
                    $result[$rowNumber][$titles[$index]] = $cell;
                } else {
                    $result[$rowNumber][] = $cell;
                }
            }

            $rowNumber++;
        }

        fclose($handle);

        return $result;
    }

    /**
     * @param array  $array
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape_char
     *
     * @return string
     */
    public static function arrayToCsvString(array $array, string $delimiter = ",", string $enclosure = '"', string $escape_char = "\\"): string
    {
        $f = fopen('php://memory', 'r+');
        foreach ($array as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);

        return trim(stream_get_contents($f));
    }
}