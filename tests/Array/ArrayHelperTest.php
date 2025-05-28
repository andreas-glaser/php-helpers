<?php

namespace AndreasGlaser\Helpers\Tests\Array;

use AndreasGlaser\Helpers\ArrayHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * ArrayHelperTest provides unit tests for the ArrayHelper class.
 *
 * This class tests various array manipulation methods:
 * - Getting and setting values by key and path
 * - Checking existence of keys and values
 * - Manipulating array elements (prepend, append, remove)
 * - Merging arrays and replacing values
 */
class ArrayHelperTest extends BaseTest
{
    /**
     * Test array for numeric keys.
     *
     * @var array
     */
    protected $array = [];

    /**
     * Test array for associative keys.
     *
     * @var array
     */
    protected $arrayAssoc = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->array = [
            123,
            'Test',
            new \stdClass(),
            [],
            true,
            false,
        ];

        $this->arrayAssoc = [
            'Index1' => 123,
            'Index2' => 'Test',
            'Index3' => new \stdClass(),
            'Index4' => [],
            'Index5' => true,
            'Index6' => false,
        ];
    }

    /**
     * Tests the get() method for retrieving values by key.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::get
     * @return void
     */
    public function testGet()
    {
        foreach ($this->array as $key => $value) {
            self::assertEquals($value, ArrayHelper::get($this->array, $key));
        }

        foreach ($this->arrayAssoc as $key => $value) {
            self::assertEquals($value, ArrayHelper::get($this->arrayAssoc, $key));
        }
    }

    /**
     * Tests the getKeyByValue() method for finding keys by value.
     * Tests various scenarios including strict/non-strict comparison and default values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::getKeyByValue
     * @return void
     */
    public function testGetByValue()
    {
        $testArray = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'duplicate',
            'k4' => 'duplicate',
            'k5' => 0,
            'k6' => '0',
            0    => 'test',
        ];

        self::assertEquals('k1', ArrayHelper::getKeyByValue($testArray, 'v1'));
        self::assertEquals('k2', ArrayHelper::getKeyByValue($testArray, 'v2'));
        self::assertEquals('k3', ArrayHelper::getKeyByValue($testArray, 'duplicate'));
        self::assertEquals(null, ArrayHelper::getKeyByValue($testArray, 'invalid'));
        self::assertEquals('k6', ArrayHelper::getKeyByValue($testArray, '0', null, true));
        self::assertEquals('k5', ArrayHelper::getKeyByValue($testArray, '0', null, false));
        self::assertEquals('something', ArrayHelper::getKeyByValue($testArray, 'invalid', 'something'));
        self::assertEquals('0', ArrayHelper::getKeyByValue($testArray, 'test'));
    }

    /**
     * Tests the getByPath() method for retrieving values using dot notation.
     * Tests accessing nested array values, custom delimiters, and error handling.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::getByPath
     * @return void
     */
    public function testGetByPath()
    {
        $testArray = [
            'index1' => 'Hey There',
            'index2' => 'This is great',
            'index3' => [
                'index4' => 'Cooool',
                'index5' => new \stdClass(),
                'abc'    => [
                    'great',
                ],
            ],
        ];

        self::assertEquals('Hey There', ArrayHelper::getByPath($testArray, 'index1'));
        self::assertInstanceOf('\stdClass', ArrayHelper::getByPath($testArray, 'index3.index5'));
        self::assertEquals('great', ArrayHelper::getByPath($testArray, 'index3.abc.0'));
        self::assertEquals('great', ArrayHelper::getByPath($testArray, 'index3:abc:0', false, null, ':'));

        self::assertNull(ArrayHelper::getByPath($testArray, 'wrong-index'));
        self::assertFalse(ArrayHelper::getByPath($testArray, 'wrong-index', false, false));
        $this->expectException('\RuntimeException');
        $this->expectExceptionMessage('Array index "wrong-key" does not exist');
        ArrayHelper::getByPath($testArray, 'wrong-key', true);
    }

    /**
     * Tests the setByPath() method for setting values using dot notation.
     * Tests setting values at different nesting levels and error handling.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::setByPath
     * @return void
     */
    public function testSetByPath()
    {
        $myArray = [
            'test'   => 'Hello',
            'index2' => [
                'index3' => [
                    'index4' => 'XYZ',
                    'index5' => 'Something',
                ],
            ],
        ];

        self::assertEquals(
            [
                'test'   => 'Bye',
                'index2' => [
                    'index3' => [
                        'index4' => 'XYZ',
                        'index5' => 'Something',
                    ],
                ],
            ],
            ArrayHelper::setByPath($myArray, 'test', 'Bye')
        );

        self::assertEquals(
            [
                'test'   => 'Hello',
                'index2' => [
                    'index3' => [
                        'index4' => 'XYZ',
                        'index5' => 'Something',
                        'test'   => 'Cheese',
                    ],
                ],
            ],
            ArrayHelper::setByPath($myArray, 'index2.index3.test', 'Cheese')
        );

        $this->expectException(
            '\RuntimeException'
        );
        $this->expectExceptionMessage(
            'Array index "test" exists already and is not of type "array"'
        );

        self::assertEquals(
            [
                'test'   => 'Hello',
                'index2' => [
                    'index3' => [
                        'index4' => 'XYZ',
                        'index5' => 'Something',
                        'test'   => 'Cheese',
                    ],
                ],
            ],
            ArrayHelper::setByPath($myArray, 'test.abc.something', 'Cheese')
        );
    }

    /**
     * Tests the unsetByPath() method for removing values using dot notation.
     * Tests removing values at different nesting levels and handling non-existent paths.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::unsetByPath
     * @return void
     */
    public function testUnsetByPath()
    {
        $myArray = [
            'test'   => 'Hello',
            'index2' => [
                'index3' => [
                    'index4' => 'XYZ',
                    'index5' => 'Something',
                ],
            ],
        ];

        self::assertEquals(
            [
                'index2' => [
                    'index3' => [
                        'index4' => 'XYZ',
                        'index5' => 'Something',
                    ],
                ],
            ],
            ArrayHelper::unsetByPath($myArray, 'test')
        );

        self::assertEquals(
            [
                'test'   => 'Hello',
                'index2' => [
                    'index3' => [
                        'index4' => 'XYZ',
                    ],
                ],
            ],
            ArrayHelper::unsetByPath($myArray, 'index2.index3.index5')
        );

        self::assertEquals(
            [
                'test'   => 'Hello',
                'index2' => [],
            ],
            ArrayHelper::unsetByPath($myArray, 'index2.index3')
        );

        self::assertEquals(
            [
                'test'   => 'Hello',
                'index2' => [
                    'index3' => [
                        'index4' => 'XYZ',
                        'index5' => 'Something',
                    ],
                ],
            ],
            ArrayHelper::unsetByPath($myArray, 'doesnot.exist')
        );
    }

    /**
     * Tests the existsByPath() method for checking if a path exists.
     * Tests various path combinations and custom delimiters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::existsByPath
     * @return void
     */
    public function testExistByPath()
    {
        $myArray = [
            'test'   => 'Hello',
            'index2' => [
                'index3' => [
                    'index4' => 'XYZ',
                    'index5' => 'Something',
                ],
            ],
        ];

        // test positive results
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'test'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2.index3'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2.index3.index4'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2.index3.index5'));

        // test negative results
        self::assertFalse(ArrayHelper::existsByPath($myArray, 'wrong-key'));
        self::assertFalse(ArrayHelper::existsByPath($myArray, 'test.wrong-key'));
        self::assertFalse(ArrayHelper::existsByPath($myArray, 'index2.wrong-key'));
        self::assertFalse(ArrayHelper::existsByPath($myArray, 'index2.index3.wrong-key'));
        self::assertFalse(ArrayHelper::existsByPath($myArray, 'index2.index3.wrong-key'));

        // test delimiter
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'test', ':'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2', ':'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2:index3', ':'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2:index3:index4', ':'));
        self::assertTrue(ArrayHelper::existsByPath($myArray, 'index2:index3:index5', ':'));
    }

    /**
     * Tests the issetByPath() method for checking if a path exists and is not null.
     * Tests various path combinations including null values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::issetByPath
     * @return void
     */
    public function testIssetByPath()
    {
        $myArray = [
            'test'   => 'Hello',
            'index2' => [
                'index3' => [
                    'index4' => 'XYZ',
                    'index5' => 'Something',
                    'index6' => null,
                ],
            ],
            'empty' => null,
        ];

        // test positive results
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'test'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2.index3'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2.index3.index4'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2.index3.index5'));

        // test negative results
        self::assertFalse(ArrayHelper::issetByPath($myArray, 'index2.index3.index6'));
        self::assertFalse(ArrayHelper::issetByPath($myArray, 'empty'));
        self::assertFalse(ArrayHelper::issetByPath($myArray, 'wrong-key'));
        self::assertFalse(ArrayHelper::issetByPath($myArray, 'test.wrong-key'));
        self::assertFalse(ArrayHelper::issetByPath($myArray, 'index2.wrong-key'));
        self::assertFalse(ArrayHelper::issetByPath($myArray, 'index2.index3.wrong-key'));
        self::assertFalse(ArrayHelper::issetByPath($myArray, 'index2.index3.wrong-key'));

        // test delimiter
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'test', ':'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2', ':'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2:index3', ':'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2:index3:index4', ':'));
        self::assertTrue(ArrayHelper::issetByPath($myArray, 'index2:index3:index5', ':'));
    }

    /**
     * Tests the prepend() method for adding elements to the beginning of an array.
     * Tests both numeric and associative arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::prepend
     * @return void
     */
    public function testPrepend()
    {
        $testArray = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'duplicate',
            'k4' => 'duplicate',
            'k5' => 0,
            'k6' => '0',
            0    => 'test',
        ];

        self::assertEquals(
            [
                1    => 'hello',
                'k1' => 'v1',
                'k2' => 'v2',
                'k3' => 'duplicate',
                'k4' => 'duplicate',
                'k5' => 0,
                'k6' => '0',
                0    => 'test',
            ],
            ArrayHelper::prepend($testArray, 'hello')
        );

        self::assertEquals(
            [
                'test' => 'hello',
                'k1'   => 'v1',
                'k2'   => 'v2',
                'k3'   => 'duplicate',
                'k4'   => 'duplicate',
                'k5'   => 0,
                'k6'   => '0',
                0      => 'test',
            ],
            ArrayHelper::prepend($testArray, 'hello', 'test')
        );
    }

    /**
     * Tests the append() method for adding elements to the end of an array.
     * Tests both numeric and associative arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::append
     * @return void
     */
    public function testAppend()
    {
        $testArray = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'duplicate',
            'k4' => 'duplicate',
            'k5' => 0,
            'k6' => '0',
            0    => 'test',
        ];

        self::assertEquals(
            [
                1    => 'hello',
                'k1' => 'v1',
                'k2' => 'v2',
                'k3' => 'duplicate',
                'k4' => 'duplicate',
                'k5' => 0,
                'k6' => '0',
                0    => 'test',
            ],
            ArrayHelper::append($testArray, 'hello')
        );

        self::assertEquals(
            [
                'test' => 'hello',
                'k1'   => 'v1',
                'k2'   => 'v2',
                'k3'   => 'duplicate',
                'k4'   => 'duplicate',
                'k5'   => 0,
                'k6'   => '0',
                0      => 'test',
            ],
            ArrayHelper::append($testArray, 'hello', 'test')
        );
    }

    /**
     * Tests the getRandomValue() method for retrieving a random array value.
     * Verifies that the returned value exists in the original array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::getRandomValue
     * @return void
     */
    public function testGetRandomValue()
    {
        $testArray = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ];

        self::assertTrue(\in_array(ArrayHelper::getRandomValue($testArray), $testArray));
    }

    /**
     * Tests the removeFirstElement() method.
     * Tests removal from numeric arrays, associative arrays, and empty arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::removeFirstElement
     * @return void
     */
    public function testRemoveFirstElement()
    {
        self::assertEquals([
            100 => 'Index 2',
            200 => 'Index 3',
        ], ArrayHelper::removeFirstElement([
            0   => 'Index 1',
            100 => 'Index 2',
            200 => 'Index 3',
        ]));

        self::assertEquals([
            'string2' => 'Index 2',
        ], ArrayHelper::removeFirstElement([
            'string1' => 'Index 1',
            'string2' => 'Index 2',
        ]));

        self::assertEquals([], ArrayHelper::removeFirstElement([]));
    }

    /**
     * Tests the removeLastElement() method.
     * Tests removal from numeric arrays, associative arrays, and empty arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::removeLastElement
     * @return void
     */
    public function testRemoveLastElement()
    {
        self::assertEquals([
            0   => 'Index 1',
            100 => 'Index 2',
        ], ArrayHelper::removeLastElement([
            0   => 'Index 1',
            100 => 'Index 2',
            200 => 'Index 3',
        ]));

        self::assertEquals([
            'string1' => 'Index 1',
        ], ArrayHelper::removeLastElement([
            'string1' => 'Index 1',
            'string2' => 'Index 2',
        ]));

        self::assertEquals([], ArrayHelper::removeLastElement([]));
    }

    /**
     * Tests the removeByValue() method.
     * Tests strict and non-strict value comparison during removal.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::removeByValue
     * @return void
     */
    public function testRemoveByValue()
    {
        $array = [
            0 => '1',
            1 => 2,
            2 => true,
            3 => false,
            4 => null,
        ];

        self::assertEquals(
            [
                0 => '1',
                2 => true,
                3 => false,
                4 => null,
            ],
            ArrayHelper::removeByValue($array, 2)
        );

        self::assertEquals(
            [
                0 => '1',
                1 => 2,
                2 => true,
                3 => false,
                4 => null,
            ],
            ArrayHelper::removeByValue($array, 1, true)
        );

        self::assertEquals(
            [
                1 => 2,
                2 => true,
                3 => false,
                4 => null,
            ],
            ArrayHelper::removeByValue($array, 1, false)
        );
    }

    /**
     * Tests the implodeKeys() method for joining array keys with a delimiter.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::implodeKeys
     * @return void
     */
    public function testImplodeKeys()
    {
        self::assertEquals(
            'rat,mouse,tiger,0,1,2',
            ArrayHelper::implodeKeys(',', ['rat' => 1, 'mouse' => 2, 'tiger' => 3, null, [], 1])
        );
    }

    /**
     * Tests the explodeIgnoreEmpty() method.
     * Verifies that empty elements are properly filtered out.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::explodeIgnoreEmpty
     * @return void
     */
    public function testExplodeIgnoreEmpty()
    {
        $testString = '1,2, 3,,4,,,,5,6,cheese,,cake';
        $explodedArray = ArrayHelper::explodeIgnoreEmpty(',', $testString);
        $expectedArray = [
            0 => '1',
            1 => '2',
            2 => ' 3',
            3 => '4',
            4 => '5',
            5 => '6',
            6 => 'cheese',
            7 => 'cake',
        ];

        self::assertEquals(8, \count($explodedArray));
        self::assertTrue(($expectedArray === $explodedArray));
    }

    /**
     * Tests the replaceValue() method.
     * Tests value replacement with various options for recursion and case sensitivity.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::replaceValue
     * @return void
     */
    public function testReplaceValue()
    {
        $testArray = [
            'honey',
            'Mustard',
            'sauce',
            'sweets' => [
                'MARS',
                'curly wurly',
                'ding dong',
                'honey',
            ],
        ];

        self::assertEquals(
            [
                'jam',
                'Mustard',
                'sauce',
                'sweets' => [
                    'MARS',
                    'curly wurly',
                    'ding dong',
                    'jam',
                ],
            ],
            ArrayHelper::replaceValue($testArray, 'honey', 'jam', true, true)
        );

        self::assertEquals(
            [
                'jam',
                'Mustard',
                'sauce',
                'sweets' => [
                    'MARS',
                    'curly wurly',
                    'ding dong',
                    'honey',
                ],
            ],
            ArrayHelper::replaceValue($testArray, 'honey', 'jam', false, true)
        );

        self::assertEquals(
            [
                'honey',
                'Mustard',
                'sauce',
                'sweets' => [
                    'MARS',
                    'curly wurly',
                    'ding dong',
                    'honey',
                ],
            ],
            ArrayHelper::replaceValue($testArray, 'HONEY', 'jam', true, true)
        );

        self::assertEquals(
            [
                'jam',
                'Mustard',
                'sauce',
                'sweets' => [
                    'MARS',
                    'curly wurly',
                    'ding dong',
                    'jam',
                ],
            ],
            ArrayHelper::replaceValue($testArray, 'HONEY', 'jam', true, false)
        );
    }

    /**
     * Tests the merge() method.
     * Tests various array merging scenarios and error handling.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\ArrayHelper::merge
     * @return void
     */
    public function testMerge()
    {
        $array1 = [
            'assoc1' => 'value1',
            'assoc2' => [
                'assoc3' => 'value2',
                10       => 'value3',
            ],
            'assoc4' => [],
            0        => 'value4',
        ];

        self::assertEquals(
            [
                'assoc1' => 'overwritten',
                'assoc2' => [
                    'assoc3' => 'value2',
                    10       => 'value3',
                ],
                'assoc4' => [],
                0        => 'value4',
            ],
            ArrayHelper::merge($array1, ['assoc1' => 'overwritten'])
        );

        self::assertEquals(
            [
                'assoc1' => 'value1',
                'assoc2' => [
                    'assoc3' => 'value2',
                    10       => 'value3',
                ],
                'assoc4' => [],
                0        => 'value4',
                1        => 'added',
            ],
            ArrayHelper::merge($array1, [0 => 'added'])
        );

        self::assertEquals(
            [
                'assoc1' => 'value1',
                'assoc2' => 'overwritten',
                'assoc4' => [],
                0        => 'value4',
            ],
            ArrayHelper::merge($array1, ['assoc2' => 'overwritten'])
        );

        self::assertEquals(
            [
                'assoc1' => 'value1',
                'assoc2' => [
                    'assoc3' => 'value2',
                    10       => 'value3',
                ],
                'assoc4' => [
                    0     => 'cheese',
                    'abc' => 'tasty',
                ],
                0 => 'value4',
            ],
            ArrayHelper::merge($array1, ['assoc4' => ['cheese', 'abc' => 'tasty']])
        );

        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Argument 2 is not an array');
        ArrayHelper::merge(['abc'], 123);
    }
}
