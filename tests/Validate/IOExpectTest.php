<?php

namespace Tests\Validate;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Validate\IOExpect;
use AndreasGlaser\Helpers\Exceptions\IOException;
use AndreasGlaser\Helpers\IOHelper;

/**
 * IOExpectTest provides unit tests for the IOExpect class.
 *
 * This class tests file system validation methods:
 * - Path existence and type validation  
 * - Permission validation (readable, writable, executable)
 * - Directory content validation (empty/not empty)
 * - File size validation (min/max size)
 * - File extension validation
 * - MIME type validation
 * - Parent directory validation
 * - Exception handling and error messages
 */
class IOExpectTest extends TestCase
{
    private string $testDir;
    private string $testFile;
    private string $nonExistentPath;

    protected function setUp(): void
    {
        // Create temporary test directory
        $this->testDir = IOHelper::createTmpDir();
        $this->testFile = $this->testDir . DIRECTORY_SEPARATOR . 'test.txt';
        $this->nonExistentPath = $this->testDir . DIRECTORY_SEPARATOR . 'nonexistent.txt';
        
        // Create test file with some content
        file_put_contents($this->testFile, 'Test content for IOExpect tests');
    }

    protected function tearDown(): void
    {
        // Clean up test directory
        if (is_dir($this->testDir)) {
            IOHelper::rmdirRecursive($this->testDir);
        }
    }

    // ========================================
    // Tests for isDir() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDir
     */
    public function testIsDirWithValidDirectory()
    {
        IOExpect::isDir($this->testDir);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDir
     */
    public function testIsDirWithFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a directory');
        IOExpect::isDir($this->testFile);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDir
     */
    public function testIsDirWithNonExistentPath()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a directory');
        IOExpect::isDir($this->nonExistentPath);
    }

    // ========================================
    // Tests for isFile() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isFile
     */
    public function testIsFileWithValidFile()
    {
        IOExpect::isFile($this->testFile);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isFile
     */
    public function testIsFileWithDirectory()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::isFile($this->testDir);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isFile
     */
    public function testIsFileWithNonExistentPath()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::isFile($this->nonExistentPath);
    }

    // ========================================
    // Tests for exists() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::exists
     */
    public function testExistsWithValidFile()
    {
        IOExpect::exists($this->testFile);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::exists
     */
    public function testExistsWithValidDirectory()
    {
        IOExpect::exists($this->testDir);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::exists
     */
    public function testExistsWithNonExistentPath()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('does not exist');
        IOExpect::exists($this->nonExistentPath);
    }

    // ========================================
    // Tests for doesNotExist() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::doesNotExist
     */
    public function testDoesNotExistWithNonExistentPath()
    {
        IOExpect::doesNotExist($this->nonExistentPath);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::doesNotExist
     */
    public function testDoesNotExistWithExistingFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('already exists');
        IOExpect::doesNotExist($this->testFile);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::doesNotExist
     */
    public function testDoesNotExistWithExistingDirectory()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('already exists');
        IOExpect::doesNotExist($this->testDir);
    }

    // ========================================
    // Tests for isReadable() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isReadable
     */
    public function testIsReadableWithReadableFile()
    {
        IOExpect::isReadable($this->testFile);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isReadable
     */
    public function testIsReadableWithReadableDirectory()
    {
        IOExpect::isReadable($this->testDir);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isReadable
     */
    public function testIsReadableWithNonExistentPath()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not readable');
        IOExpect::isReadable($this->nonExistentPath);
    }

    // ========================================
    // Tests for isWritable() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isWritable
     */
    public function testIsWritableWithWritableFile()
    {
        IOExpect::isWritable($this->testFile);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isWritable
     */
    public function testIsWritableWithWritableDirectory()
    {
        IOExpect::isWritable($this->testDir);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isWritable
     */
    public function testIsWritableWithNonExistentPath()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not writable');
        IOExpect::isWritable($this->nonExistentPath);
    }

    // ========================================
    // Tests for isExecutable() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isExecutable
     */
    public function testIsExecutableWithNonExecutableFile()
    {
        // Most regular files are not executable by default
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not executable');
        IOExpect::isExecutable($this->testFile);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isExecutable
     */
    public function testIsExecutableWithNonExistentPath()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not executable');
        IOExpect::isExecutable($this->nonExistentPath);
    }

    // ========================================
    // Tests for isLink() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isLink
     */
    public function testIsLinkWithRegularFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a symbolic link');
        IOExpect::isLink($this->testFile);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isLink
     */
    public function testIsLinkWithNonExistentPath()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a symbolic link');
        IOExpect::isLink($this->nonExistentPath);
    }

    // ========================================
    // Tests for isDirEmpty() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDirEmpty
     */
    public function testIsDirEmptyWithEmptyDirectory()
    {
        $emptyDir = $this->testDir . DIRECTORY_SEPARATOR . 'empty';
        mkdir($emptyDir);
        
        IOExpect::isDirEmpty($emptyDir);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDirEmpty
     */
    public function testIsDirEmptyWithNonEmptyDirectory()
    {
        // testDir contains the test file, so it's not empty
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not empty');
        IOExpect::isDirEmpty($this->testDir);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDirEmpty
     */
    public function testIsDirEmptyWithFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a directory');
        IOExpect::isDirEmpty($this->testFile);
    }

    // ========================================
    // Tests for isDirNotEmpty() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDirNotEmpty
     */
    public function testIsDirNotEmptyWithNonEmptyDirectory()
    {
        // testDir contains the test file, so it's not empty
        IOExpect::isDirNotEmpty($this->testDir);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDirNotEmpty
     */
    public function testIsDirNotEmptyWithEmptyDirectory()
    {
        $emptyDir = $this->testDir . DIRECTORY_SEPARATOR . 'empty';
        mkdir($emptyDir);
        
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is empty');
        IOExpect::isDirNotEmpty($emptyDir);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isDirNotEmpty
     */
    public function testIsDirNotEmptyWithFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a directory');
        IOExpect::isDirNotEmpty($this->testFile);
    }

    // ========================================
    // Tests for hasMinSize() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMinSize
     */
    public function testHasMinSizeWithValidSize()
    {
        // Test file has content, so it should be larger than 1 byte
        IOExpect::hasMinSize($this->testFile, 1);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMinSize
     */
    public function testHasMinSizeWithTooLargeMinimum()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is smaller than required minimum');
        IOExpect::hasMinSize($this->testFile, 1000000); // 1MB minimum
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMinSize
     */
    public function testHasMinSizeWithNonExistentFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::hasMinSize($this->nonExistentPath, 1);
    }

    // ========================================
    // Tests for hasMaxSize() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMaxSize
     */
    public function testHasMaxSizeWithValidSize()
    {
        // Test file should be smaller than 1MB
        IOExpect::hasMaxSize($this->testFile, 1000000); // 1MB maximum
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMaxSize
     */
    public function testHasMaxSizeWithTooSmallMaximum()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('exceeds maximum allowed');
        IOExpect::hasMaxSize($this->testFile, 1); // 1 byte maximum
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMaxSize
     */
    public function testHasMaxSizeWithNonExistentFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::hasMaxSize($this->nonExistentPath, 1000);
    }

    // ========================================
    // Tests for hasExtension() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasExtension
     */
    public function testHasExtensionWithCorrectExtension()
    {
        IOExpect::hasExtension($this->testFile, 'txt');
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasExtension
     */
    public function testHasExtensionWithDotPrefix()
    {
        IOExpect::hasExtension($this->testFile, '.txt');
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasExtension
     */
    public function testHasExtensionWithWrongExtension()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('does not have expected extension');
        IOExpect::hasExtension($this->testFile, 'pdf');
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasExtension
     */
    public function testHasExtensionWithNonExistentFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::hasExtension($this->nonExistentPath, 'txt');
    }

    // ========================================
    // Tests for hasAllowedExtension() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasAllowedExtension
     */
    public function testHasAllowedExtensionWithValidExtension()
    {
        IOExpect::hasAllowedExtension($this->testFile, ['txt', 'log', 'csv']);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasAllowedExtension
     */
    public function testHasAllowedExtensionWithDotPrefixes()
    {
        IOExpect::hasAllowedExtension($this->testFile, ['.txt', '.log', '.csv']);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasAllowedExtension
     */
    public function testHasAllowedExtensionWithInvalidExtension()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('does not have an allowed extension');
        IOExpect::hasAllowedExtension($this->testFile, ['pdf', 'doc', 'xls']);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasAllowedExtension
     */
    public function testHasAllowedExtensionWithNonExistentFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::hasAllowedExtension($this->nonExistentPath, ['txt']);
    }

    // ========================================
    // Tests for parentDirWritable() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::parentDirWritable
     */
    public function testParentDirWritableWithWritableParent()
    {
        IOExpect::parentDirWritable($this->testFile);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::parentDirWritable
     */
    public function testParentDirWritableWithNonExistentParent()
    {
        $deepPath = $this->testDir . DIRECTORY_SEPARATOR . 'nonexistent' . DIRECTORY_SEPARATOR . 'file.txt';
        
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a directory');
        IOExpect::parentDirWritable($deepPath);
    }

    // ========================================
    // Tests for isFileNotEmpty() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isFileNotEmpty
     */
    public function testIsFileNotEmptyWithNonEmptyFile()
    {
        IOExpect::isFileNotEmpty($this->testFile);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isFileNotEmpty
     */
    public function testIsFileNotEmptyWithEmptyFile()
    {
        $emptyFile = $this->testDir . DIRECTORY_SEPARATOR . 'empty.txt';
        file_put_contents($emptyFile, '');
        
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is empty');
        IOExpect::isFileNotEmpty($emptyFile);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::isFileNotEmpty
     */
    public function testIsFileNotEmptyWithNonExistentFile()
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::isFileNotEmpty($this->nonExistentPath);
    }

    // ========================================
    // Tests for hasMimeType() method
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMimeType
     */
    public function testHasMimeTypeWithTextFile()
    {
        if (!function_exists('finfo_open')) {
            $this->markTestSkipped('fileinfo extension is not available');
        }
        
        IOExpect::hasMimeType($this->testFile, 'text/plain');
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMimeType
     */
    public function testHasMimeTypeWithWrongMimeType()
    {
        if (!function_exists('finfo_open')) {
            $this->markTestSkipped('fileinfo extension is not available');
        }
        
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('does not have expected MIME type');
        IOExpect::hasMimeType($this->testFile, 'image/jpeg');
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMimeType
     */
    public function testHasMimeTypeWithNonExistentFile()
    {
        if (!function_exists('finfo_open')) {
            $this->markTestSkipped('fileinfo extension is not available');
        }
        
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('is not a file');
        IOExpect::hasMimeType($this->nonExistentPath, 'text/plain');
    }

    // ========================================
    // Tests for exception path property
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::exists
     */
    public function testExceptionContainsPath()
    {
        try {
            IOExpect::exists($this->nonExistentPath);
            $this->fail('Expected IOException was not thrown');
        } catch (IOException $e) {
            $this->assertEquals($this->nonExistentPath, $e->getPath());
            $this->assertStringContainsString($this->nonExistentPath, $e->getMessage());
        }
    }

    // ========================================
    // Tests for edge cases and special scenarios
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMinSize
     */
    public function testHasMinSizeZeroBytes()
    {
        $emptyFile = $this->testDir . DIRECTORY_SEPARATOR . 'empty.txt';
        file_put_contents($emptyFile, '');
        
        IOExpect::hasMinSize($emptyFile, 0);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasMaxSize
     */
    public function testHasMaxSizeExactMatch()
    {
        $fileSize = filesize($this->testFile);
        IOExpect::hasMaxSize($this->testFile, $fileSize);
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasExtension
     */
    public function testHasExtensionCaseInsensitive()
    {
        IOExpect::hasExtension($this->testFile, 'TXT'); // Should be case insensitive
        $this->assertTrue(true); // No exception thrown
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\IOExpect::hasExtension
     */
    public function testHasExtensionWithNoExtension()
    {
        $fileWithoutExt = $this->testDir . DIRECTORY_SEPARATOR . 'noext';
        file_put_contents($fileWithoutExt, 'content');
        
        $this->expectException(IOException::class);
        $this->expectExceptionMessage('does not have expected extension');
        IOExpect::hasExtension($fileWithoutExt, 'txt');
    }
} 