<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\CsvHelper;

/**
 * Class CsvHelperTest.
 */
class CsvHelperTest extends BaseTest
{
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
