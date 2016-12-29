<?php

namespace AndreasGlaser\Helpers;

/**
 * Class CsvHelper
 *
 * @package AndreasGlaser\Helpers
 *
 * @author  Andreas Glaser
 */
class CsvHelper
{

    /**
     * @param        $file
     * @param bool   $isFirstLineTitle
     * @param int    $length
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public static function fileToArray($file, $isFirstLineTitle = false, $length = 0, $delimiter = ',', $enclosure = '"', $escape = "\\")
    {
        if (!is_file($file)) {
            throw new \RuntimeException('Not a file');
        }

        if (!is_readable($file)) {
            throw new \RuntimeException('File is not readable');
        }

        $returnArray = [];

        $titles = [];
        $rowNumber = 0;

        if (($handle = fopen($file, 'r')) !== false) {
            while (($rowData = fgetcsv($handle, $length, $delimiter, $enclosure, $escape)) !== false) {

                if ($isFirstLineTitle && $rowNumber === 0) {
                    foreach ($rowData AS $index => $title) {
                        $titles[$index] = $title;
                    }
                    $rowNumber++;
                    continue;
                }

                $returnArray[$rowNumber] = [];

                foreach ($rowData AS $index => $cell) {

                    if ($isFirstLineTitle) {
                        $returnArray[$rowNumber][$titles[$index]] = $cell;
                    } else {
                        $returnArray[$rowNumber][] = $cell;
                    }
                }

                $rowNumber++;
            }
            fclose($handle);
        }

        return $returnArray;
    }
}