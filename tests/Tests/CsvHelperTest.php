<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\CsvHelper;

/**
 * CsvHelperTest provides unit tests for the CsvHelper class.
 *
 * This class tests CSV file operations:
 * - Parsing CSV files with title rows
 * - Converting arrays to CSV strings
 * - Handling different delimiters and quote characters
 */
class CsvHelperTest extends BaseTest
{
    /**
     * Tests parsing a CSV file with a title row into an associative array.
     */
    public function testParseCsvWithTitleRow()
    {
        $csvFile = __DIR__ . '/../ExtraFiles/WithTitleRow.csv';
        $array = CsvHelper::fileToArray($csvFile, true);

        self::assertEquals(1, \count($array));

        self::assertArrayHasKey('id', $array[0]);
        self::assertArrayHasKey('name', $array[0]);
        self::assertArrayHasKey('value', $array[0]);

        self::assertEquals('12', $array[0]['id']);
        self::assertEquals('test', $array[0]['name']);
        self::assertEquals('test xyz', $array[0]['value']);
    }

    /**
     * Tests converting arrays to CSV strings with various delimiters and quote characters.
     */
    public function testArrayToCsvString()
    {
        $array1 = [
            [
                'ID',
                'Name',
                'Description',
            ],
            [
                1,
                'Test 1',
                'Some Text',
            ],
            [
                2,
                'Test 2',
                'Includes "quotes"',
            ],
            [
                3,
                'Test 3',
                'Includes \'quotes\'',
            ],
        ];

        $array2 = [
            [
                'ID',
                'Name',
                'Description',
            ],
            [
                1,
                'Test 1',
                'Includes a "|" pipe',
            ],
        ];

        $array3 = [
            [
                'ID',
                'Name',
                'Description',
            ],
            [
                1,
                'Test 1',
                'Includes "quotes"',
            ],
            [
                2,
                'Test 2',
                'Includes \'quotes\'',
            ],
        ];

        self::assertEquals('ID,Name,Description
1,"Test 1","Some Text"
2,"Test 2","Includes ""quotes"""
3,"Test 3","Includes \'quotes\'"', CsvHelper::arrayToCsvString($array1));

        self::assertEquals('ID|Name|Description
1|"Test 1"|"Includes a ""|"" pipe"', CsvHelper::arrayToCsvString($array2, '|'));

        self::assertEquals("ID,Name,Description
1,'Test 1','Includes \"quotes\"'
2,'Test 2','Includes ''quotes'''", CsvHelper::arrayToCsvString($array3, ',', "'"));
    }
}
