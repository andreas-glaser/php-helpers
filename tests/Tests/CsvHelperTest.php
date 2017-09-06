<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\CsvHelper;

/**
 * Class CsvHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 */
class CsvHelperTest extends BaseTest
{
    public function testParseCsvWithTitleRow()
    {
        $csvFile = __DIR__ . '/../ExtraFiles/WithTitleRow.csv';
        $array = CsvHelper::fileToArray($csvFile, true);

        $this->assertEquals(1, count($array));

        $this->assertArrayHasKey('id', $array[0]);
        $this->assertArrayHasKey('name', $array[0]);
        $this->assertArrayHasKey('value', $array[0]);

        $this->assertEquals('12', $array[0]['id']);
        $this->assertEquals('test', $array[0]['name']);
        $this->assertEquals('test xyz', $array[0]['value']);
    }
}