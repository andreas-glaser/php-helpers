<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Validate\IOExpect;

/**
 * Class CsvHelper.
 */
class CsvHelper
{
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
