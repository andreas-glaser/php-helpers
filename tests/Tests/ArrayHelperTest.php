<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\ArrayHelper;

/**
 * Class ArrayHelperTest.
 */
class ArrayHelperTest extends BaseTest
{
    /**
     * Test array.
     *
     * @var array
     */
    protected $array = [];

    /**
     * Associative test array.
     *
     * @var array
     */
    protected $arrayAssoc = [];

    /**
     * @param null   $name
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

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

    public function testGet()
    {
        foreach ($this->array as $key => $value) {
            self::assertEquals($value, ArrayHelper::get($this->array, $key));
        }

        foreach ($this->arrayAssoc as $key => $value) {
            self::assertEquals($value, ArrayHelper::get($this->arrayAssoc, $key));
        }
    }

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

    public function testGetRandomValue()
    {
        $testArray = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ];

        self::assertTrue(\in_array(ArrayHelper::getRandomValue($testArray), $testArray));
    }

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

    public function testImplodeKeys()
    {
        self::assertEquals(
            'rat,mouse,tiger,0,1,2',
            ArrayHelper::implodeKeys(',', ['rat' => 1, 'mouse' => 2, 'tiger' => 3, null, [], 1])
        );
    }

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
