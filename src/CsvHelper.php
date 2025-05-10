<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Validate\IOExpect;

/**
 * CsvHelper provides utility methods for working with CSV files and data.
 * 
 * This class contains methods for reading CSV files into arrays and
 * converting arrays to CSV strings, with support for custom delimiters,
 * enclosures, and escape characters.
 */
class CsvHelper
{
    /**
     * Reads a CSV file and converts it to an array.
     *
     * @param string $file The path to the CSV file
     * @param bool $isFirstLineTitle Whether to use the first line as column titles
     * @param int $length The maximum line length to read
     * @param string $delimiter The field delimiter character
     * @param string $enclosure The field enclosure character
     * @param string $escape The escape character
     *
     * @return array The CSV data as an array
     *
     * @throws \AndreasGlaser\Helpers\Exceptions\IOException If the file doesn't exist or isn't readable
     */
    public static function fileToArray(string $file, bool $isFirstLineTitle = false, int $length = 0, string $delimiter = ',', string $enclosure = '"', string $escape = '\\'): array
    {
        IOExpect::isFile($file);
        IOExpect::isReadable($file);

        $result = [];
        $titles = [];
        $hasTitles = false;
        $rowNumber = 0;

        $handle = \fopen($file, 'r');

        while (false !== ($row = \fgetcsv($handle, $length, $delimiter, $enclosure, $escape))) {
            if (true === $isFirstLineTitle && false === $hasTitles) {
                foreach ($row as $index => $title) {
                    $titles[$index] = $title;
                }
                $hasTitles = true;
                continue;
            }

            $result[$rowNumber] = [];

            foreach ($row as $index => $cell) {
                if (true === $isFirstLineTitle) {
                    $result[$rowNumber][$titles[$index]] = $cell;
                } else {
                    $result[$rowNumber][] = $cell;
                }
            }

            ++$rowNumber;
        }

        \fclose($handle);

        return $result;
    }

    /**
     * Converts an array to a CSV string.
     *
     * @param array $array The array to convert
     * @param string $delimiter The field delimiter character
     * @param string $enclosure The field enclosure character
     * @param string $escape_char The escape character
     *
     * @return string The CSV data as a string
     */
    public static function arrayToCsvString(array $array, string $delimiter = ',', string $enclosure = '"', string $escape_char = '\\'): string
    {
        $f = \fopen('php://memory', 'r+');
        foreach ($array as $item) {
            \fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        \rewind($f);

        return \trim(\stream_get_contents($f));
    }
}
