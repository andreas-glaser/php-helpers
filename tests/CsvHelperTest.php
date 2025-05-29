<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\CsvHelper;
use AndreasGlaser\Helpers\IOHelper;
use AndreasGlaser\Helpers\Exceptions\IOException;

/**
 * CsvHelperTest provides unit tests for the CsvHelper class.
 *
 * This class tests CSV file processing methods:
 * - File to array conversion with various options
 * - Array to CSV string conversion
 * - Custom delimiters, enclosures, and escape characters
 * - Title row handling and column mapping
 * - File validation and error handling
 * - Edge cases and special characters
 * 
 * Each method is tested with valid inputs, invalid inputs, edge cases,
 * and proper exception handling with correct error messages.
 */
class CsvHelperTest extends TestCase
{
    /**
     * @var string Temporary directory for test files
     */
    private static $tempDir;

    /**
     * Set up temporary directory for test files using IOHelper.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$tempDir = IOHelper::createTmpDir(null, 'csv_helper_test_', false);
    }

    /**
     * Clean up temporary directory using IOHelper.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        if (is_dir(self::$tempDir)) {
            IOHelper::rmdirRecursive(self::$tempDir);
        }
    }

    /**
     * Creates a temporary CSV file with given content using IOHelper.
     *
     * @param string $content CSV content
     * @param string $filename Optional filename (ignored when using IOHelper::createTmpFile)
     * @return string Full path to the created file
     */
    private function createTempCsvFile(string $content, string $filename = 'test.csv'): string
    {
        // Use IOHelper for better file management and automatic cleanup
        $filePath = IOHelper::createTmpFile(self::$tempDir, 'csv_test_', false);
        file_put_contents($filePath, $content);
        return $filePath;
    }

    // ========================================
    // Tests for fileToArray() method
    // ========================================

    /**
     * Tests the fileToArray() method with basic CSV data.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayBasic()
    {
        $csvContent = "John,Doe,25\nJane,Smith,30\nBob,Johnson,35";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath);

        $expected = [
            0 => ['John', 'Doe', '25'],
            1 => ['Jane', 'Smith', '30'],
            2 => ['Bob', 'Johnson', '35']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with title row.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithTitleRow()
    {
        $csvContent = "FirstName,LastName,Age\nJohn,Doe,25\nJane,Smith,30\nBob,Johnson,35";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath, true);

        $expected = [
            0 => ['FirstName' => 'John', 'LastName' => 'Doe', 'Age' => '25'],
            1 => ['FirstName' => 'Jane', 'LastName' => 'Smith', 'Age' => '30'],
            2 => ['FirstName' => 'Bob', 'LastName' => 'Johnson', 'Age' => '35']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with custom delimiter.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithCustomDelimiter()
    {
        $csvContent = "John;Doe;25\nJane;Smith;30\nBob;Johnson;35";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath, false, 0, ';');

        $expected = [
            0 => ['John', 'Doe', '25'],
            1 => ['Jane', 'Smith', '30'],
            2 => ['Bob', 'Johnson', '35']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with custom enclosure.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithCustomEnclosure()
    {
        $csvContent = "'John Doe','Software Engineer','New York'\n'Jane Smith','Designer','Los Angeles'";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath, false, 0, ',', "'");

        $expected = [
            0 => ['John Doe', 'Software Engineer', 'New York'],
            1 => ['Jane Smith', 'Designer', 'Los Angeles']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with quoted fields containing delimiters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithQuotedFields()
    {
        $csvContent = '"John, Jr.",Doe,25' . "\n" . '"Jane",Smith,30';
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath);

        $expected = [
            0 => ['John, Jr.', 'Doe', '25'],
            1 => ['Jane', 'Smith', '30']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with escaped quotes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithEscapedQuotes()
    {
        $csvContent = '"He said ""Hello""",World,Test';
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath);

        $expected = [
            0 => ['He said "Hello"', 'World', 'Test']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with empty CSV file.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithEmptyFile()
    {
        $filePath = $this->createTempCsvFile('');

        $result = CsvHelper::fileToArray($filePath);

        $this->assertEquals([], $result);
    }

    /**
     * Tests the fileToArray() method with only header row.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithOnlyHeaderRow()
    {
        $csvContent = "Name,Email,Age";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath, true);

        $this->assertEquals([], $result);
    }

    /**
     * Tests the fileToArray() method with mixed data types.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithMixedDataTypes()
    {
        $csvContent = "Name,Active,Price,Date\nProduct1,true,19.99,2024-01-01\nProduct2,false,0,";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath, true);

        $expected = [
            0 => ['Name' => 'Product1', 'Active' => 'true', 'Price' => '19.99', 'Date' => '2024-01-01'],
            1 => ['Name' => 'Product2', 'Active' => 'false', 'Price' => '0', 'Date' => '']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with Unicode characters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithUnicodeCharacters()
    {
        $csvContent = "José,Müller,François\nΑλέξανδρος,山田,Владимир";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath);

        $expected = [
            0 => ['José', 'Müller', 'François'],
            1 => ['Αλέξανδρος', '山田', 'Владимир']
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with newlines in fields.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithNewlinesInFields()
    {
        $csvContent = "\"Line 1\nLine 2\",Regular,\"Another\nMultiline\nField\"";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath);

        $expected = [
            0 => ["Line 1\nLine 2", 'Regular', "Another\nMultiline\nField"]
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the fileToArray() method with large datasets.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithLargeDataset()
    {
        $rows = [];
        for ($i = 1; $i <= 1000; $i++) {
            $rows[] = "User{$i},user{$i}@example.com,{$i}";
        }
        $csvContent = implode("\n", $rows);
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath);

        $this->assertCount(1000, $result);
        $this->assertEquals(['User1', 'user1@example.com', '1'], $result[0]);
        $this->assertEquals(['User1000', 'user1000@example.com', '1000'], $result[999]);
    }

    /**
     * Tests the fileToArray() method with non-existent file.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithNonExistentFile()
    {
        $this->expectException(IOException::class);
        CsvHelper::fileToArray('/non/existent/file.csv');
    }

    /**
     * Tests the fileToArray() method with unreadable file.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithUnreadableFile()
    {
        $filePath = $this->createTempCsvFile('test,data');
        
        // Make file unreadable (if possible on the system)
        if (chmod($filePath, 0000)) {
            $this->expectException(IOException::class);
            try {
                CsvHelper::fileToArray($filePath);
            } finally {
                // Restore permissions for cleanup
                chmod($filePath, 0644);
            }
        } else {
            // Skip test if chmod fails (e.g., on Windows)
            $this->markTestSkipped('Cannot change file permissions on this system');
        }
    }

    /**
     * Tests the fileToArray() method with directory instead of file.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithDirectory()
    {
        $this->expectException(IOException::class);
        CsvHelper::fileToArray(self::$tempDir);
    }

    // ========================================
    // Tests for arrayToCsvString() method
    // ========================================

    /**
     * Tests the arrayToCsvString() method with basic array data.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringBasic()
    {
        $array = [
            ['John', 'Doe', '25'],
            ['Jane', 'Smith', '30'],
            ['Bob', 'Johnson', '35']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "John,Doe,25\nJane,Smith,30\nBob,Johnson,35";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with custom delimiter.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithCustomDelimiter()
    {
        $array = [
            ['John', 'Doe', '25'],
            ['Jane', 'Smith', '30']
        ];

        $result = CsvHelper::arrayToCsvString($array, ';');

        $expected = "John;Doe;25\nJane;Smith;30";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with custom enclosure.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithCustomEnclosure()
    {
        $array = [
            ['John Doe', 'Software Engineer'],
            ['Jane Smith', 'Designer']
        ];

        $result = CsvHelper::arrayToCsvString($array, ',', "'");

        $expected = "'John Doe','Software Engineer'\n'Jane Smith',Designer";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with fields containing delimiters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithFieldsContainingDelimiters()
    {
        $array = [
            ['John, Jr.', 'Doe', '25'],
            ['Jane', 'Smith-Jones', '30']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "\"John, Jr.\",Doe,25\nJane,Smith-Jones,30";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with fields containing quotes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithFieldsContainingQuotes()
    {
        $array = [
            ['He said "Hello"', 'World'],
            ['She said "Hi"', 'Everyone']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "\"He said \"\"Hello\"\"\",World\n\"She said \"\"Hi\"\"\",Everyone";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with empty array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithEmptyArray()
    {
        $result = CsvHelper::arrayToCsvString([]);

        $this->assertEquals('', $result);
    }

    /**
     * Tests the arrayToCsvString() method with empty rows.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithEmptyRows()
    {
        $array = [
            ['John', 'Doe'],
            [],
            ['Jane', 'Smith']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "John,Doe\n\nJane,Smith";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with null and empty values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithNullAndEmptyValues()
    {
        $array = [
            ['John', null, ''],
            ['', 'Smith', null]
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "John,,\n,Smith,";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with numeric values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithNumericValues()
    {
        $array = [
            [1, 2.5, -10],
            [0, 99.99, 1e10]
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "1,2.5,-10\n0,99.99,10000000000";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with boolean values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithBooleanValues()
    {
        $array = [
            [true, false],
            [1, 0]
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "1,\n1,0";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with Unicode characters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithUnicodeCharacters()
    {
        $array = [
            ['José', 'Müller', 'François'],
            ['Αλέξανδρος', '山田', 'Владимир']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "José,Müller,François\nΑλέξανδρος,山田,Владимир";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with newlines in fields.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithNewlinesInFields()
    {
        $array = [
            ["Line 1\nLine 2", 'Regular'],
            ["Another\nMultiline\nField", 'Normal']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "\"Line 1\nLine 2\",Regular\n\"Another\nMultiline\nField\",Normal";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with associative arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithAssociativeArrays()
    {
        $array = [
            ['name' => 'John', 'age' => '25', 'city' => 'New York'],
            ['name' => 'Jane', 'age' => '30', 'city' => 'Los Angeles']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "John,25,\"New York\"\nJane,30,\"Los Angeles\"";
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests the arrayToCsvString() method with mixed indexed and associative arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringWithMixedArrays()
    {
        $array = [
            ['John', 'Doe', '25'],
            ['name' => 'Jane', 'surname' => 'Smith', 'age' => '30']
        ];

        $result = CsvHelper::arrayToCsvString($array);

        $expected = "John,Doe,25\nJane,Smith,30";
        $this->assertEquals($expected, $result);
    }

    // ========================================
    // Tests for round-trip conversion
    // ========================================

    /**
     * Tests round-trip conversion: array to CSV string to array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testRoundTripConversion()
    {
        $originalArray = [
            ['John', 'Doe', '25', 'Engineer'],
            ['Jane', 'Smith', '30', 'Designer'],
            ['Bob', 'Johnson', '35', 'Manager']
        ];

        // Convert array to CSV string
        $csvString = CsvHelper::arrayToCsvString($originalArray);

        // Write to file and read back
        $filePath = $this->createTempCsvFile($csvString);
        $resultArray = CsvHelper::fileToArray($filePath);

        $this->assertEquals($originalArray, $resultArray);
    }

    /**
     * Tests round-trip conversion with title row.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testRoundTripConversionWithTitleRow()
    {
        $headerArray = [['Name', 'Surname', 'Age', 'Job']];
        $dataArray = [
            ['John', 'Doe', '25', 'Engineer'],
            ['Jane', 'Smith', '30', 'Designer']
        ];
        $fullArray = array_merge($headerArray, $dataArray);

        // Convert to CSV
        $csvString = CsvHelper::arrayToCsvString($fullArray);

        // Write and read back with title row
        $filePath = $this->createTempCsvFile($csvString);
        $resultArray = CsvHelper::fileToArray($filePath, true);

        $expected = [
            0 => ['Name' => 'John', 'Surname' => 'Doe', 'Age' => '25', 'Job' => 'Engineer'],
            1 => ['Name' => 'Jane', 'Surname' => 'Smith', 'Age' => '30', 'Job' => 'Designer']
        ];

        $this->assertEquals($expected, $resultArray);
    }

    /**
     * Tests round-trip conversion with custom delimiters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testRoundTripConversionWithCustomDelimiters()
    {
        $originalArray = [
            ['John', 'Doe', '25'],
            ['Jane', 'Smith', '30']
        ];

        // Convert with custom delimiter
        $csvString = CsvHelper::arrayToCsvString($originalArray, ';');

        // Write and read back with same delimiter
        $filePath = $this->createTempCsvFile($csvString);
        $resultArray = CsvHelper::fileToArray($filePath, false, 0, ';');

        $this->assertEquals($originalArray, $resultArray);
    }

    // ========================================
    // Tests for edge cases and error conditions
    // ========================================

    /**
     * Tests behavior with very long lines.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testFileToArrayWithVeryLongLines()
    {
        $longField = str_repeat('A', 10000);
        $csvContent = "Short,$longField,End\nAnother,Field,Test";
        $filePath = $this->createTempCsvFile($csvContent);

        $result = CsvHelper::fileToArray($filePath);

        $this->assertCount(2, $result);
        $this->assertEquals('Short', $result[0][0]);
        $this->assertEquals($longField, $result[0][1]);
        $this->assertEquals('End', $result[0][2]);
    }

    /**
     * Tests performance with large arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @return void
     */
    public function testArrayToCsvStringPerformance()
    {
        $largeArray = [];
        for ($i = 0; $i < 1000; $i++) {
            $largeArray[] = ["Field1_$i", "Field2_$i", "Field3_$i"];
        }

        $result = CsvHelper::arrayToCsvString($largeArray);

        $this->assertIsString($result);
        $this->assertStringContainsString('Field1_0', $result);
        $this->assertStringContainsString('Field1_999', $result);

        // Count lines (should be 1000)
        $lines = explode("\n", $result);
        $this->assertCount(1000, $lines);
    }

    /**
     * Tests handling of special characters in different contexts.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\CsvHelper::arrayToCsvString
     * @covers \AndreasGlaser\Helpers\CsvHelper::fileToArray
     * @return void
     */
    public function testSpecialCharacterHandling()
    {
        $specialArray = [
            ["Tab\t", "Comma,", "Quote\""],
            ["Line\nBreak", "Simple", "Text"]
        ];

        $csvString = CsvHelper::arrayToCsvString($specialArray);
        $filePath = $this->createTempCsvFile($csvString);
        $resultArray = CsvHelper::fileToArray($filePath);

        // Test basic structure is preserved
        $this->assertCount(2, $resultArray);
        $this->assertCount(3, $resultArray[0]);
        $this->assertCount(3, $resultArray[1]);
        
        // Test that some special characters are handled
        $this->assertStringContainsString('Tab', $resultArray[0][0]);
        $this->assertStringContainsString('Simple', $resultArray[1][1]);
    }
} 