<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\ArrayHelper;

/**
 * Class ArrayHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class ArrayHelperTest extends BaseTest
{
    /**
     * Test array
     *
     * @var array
     */
    protected $array = [];

    /**
     * Associative test array
     *
     * @var array
     */
    protected $arrayAssoc = [];

    /**
     * @param null   $name
     * @param array  $data
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

    /**
     * @author Andreas Glaser
     */
    public function testGet()
    {
        foreach ($this->array AS $key => $value) {
            $this->assertEquals($value, ArrayHelper::get($this->array, $key));
        }

        foreach ($this->arrayAssoc AS $key => $value) {
            $this->assertEquals($value, ArrayHelper::get($this->arrayAssoc, $key));
        }
    }

    /**
     * @author Andreas Glaser
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

        $this->assertEquals('k1', ArrayHelper::getKeyByValue($testArray, 'v1'));
        $this->assertEquals('k2', ArrayHelper::getKeyByValue($testArray, 'v2'));
        $this->assertEquals('k3', ArrayHelper::getKeyByValue($testArray, 'duplicate'));
        $this->assertEquals(null, ArrayHelper::getKeyByValue($testArray, 'invalid'));
        $this->assertEquals('k6', ArrayHelper::getKeyByValue($testArray, '0', null, true));
        $this->assertEquals('k5', ArrayHelper::getKeyByValue($testArray, '0', null, false));
        $this->assertEquals('something', ArrayHelper::getKeyByValue($testArray, 'invalid', 'something'));
        $this->assertEquals('0', ArrayHelper::getKeyByValue($testArray, 'test'));
    }

    /**
     * @author Andreas Glaser
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

        $this->assertEquals('Hey There', ArrayHelper::getByPath($testArray, 'index1'));
        $this->assertInstanceOf('\stdClass', ArrayHelper::getByPath($testArray, 'index3.index5'));
        $this->assertEquals('great', ArrayHelper::getByPath($testArray, 'index3.abc.0'));
        $this->assertEquals('great', ArrayHelper::getByPath($testArray, 'index3:abc:0', false, null, ':'));

        $this->assertNull(ArrayHelper::getByPath($testArray, 'wrong-index'));
        $this->assertFalse(ArrayHelper::getByPath($testArray, 'wrong-index', false, false));
        $this->setExpectedException('\RuntimeException', 'Array index "wrong-key" does not exist');
        ArrayHelper::getByPath($testArray, 'wrong-key', true);
    }

    /**
     * @author Andreas Glaser
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

        $this->assertEquals(
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

        $this->assertEquals(
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

        $this->setExpectedException(
            '\RuntimeException',
            'Array index "test" exists already and is not of type "array"'
        );

        $this->assertEquals(
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
     * @author Andreas Glaser
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
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'test'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2.index3'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2.index3.index4'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2.index3.index5'));

        // test negative results
        $this->assertFalse(ArrayHelper::existsByPath($myArray, 'wrong-key'));
        $this->assertFalse(ArrayHelper::existsByPath($myArray, 'test.wrong-key'));
        $this->assertFalse(ArrayHelper::existsByPath($myArray, 'index2.wrong-key'));
        $this->assertFalse(ArrayHelper::existsByPath($myArray, 'index2.index3.wrong-key'));
        $this->assertFalse(ArrayHelper::existsByPath($myArray, 'index2.index3.wrong-key'));

        // test delimiter
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'test', ':'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2', ':'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2:index3', ':'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2:index3:index4', ':'));
        $this->assertTrue(ArrayHelper::existsByPath($myArray, 'index2:index3:index5', ':'));
    }

    /**
     * @author Andreas Glaser
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
            'empty'  => null,
        ];

        // test positive results
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'test'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2.index3'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2.index3.index4'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2.index3.index5'));

        // test negative results
        $this->assertFalse(ArrayHelper::issetByPath($myArray, 'index2.index3.index6'));
        $this->assertFalse(ArrayHelper::issetByPath($myArray, 'empty'));
        $this->assertFalse(ArrayHelper::issetByPath($myArray, 'wrong-key'));
        $this->assertFalse(ArrayHelper::issetByPath($myArray, 'test.wrong-key'));
        $this->assertFalse(ArrayHelper::issetByPath($myArray, 'index2.wrong-key'));
        $this->assertFalse(ArrayHelper::issetByPath($myArray, 'index2.index3.wrong-key'));
        $this->assertFalse(ArrayHelper::issetByPath($myArray, 'index2.index3.wrong-key'));

        // test delimiter
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'test', ':'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2', ':'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2:index3', ':'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2:index3:index4', ':'));
        $this->assertTrue(ArrayHelper::issetByPath($myArray, 'index2:index3:index5', ':'));
    }

    /**
     * @author Andreas Glaser
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

        $this->assertEquals(
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

        $this->assertEquals(
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
     * @author Andreas Glaser
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

        $this->assertEquals(
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

        $this->assertEquals(
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

    public function testInsertBefore()
    {
        $this->todo();
    }

    public function testInsertAfter()
    {
        $this->todo();
    }

    public function testGetFirstValue()
    {
        $this->todo();
    }

    public function testGetLastValue()
    {
        $this->todo();
    }

    /**
     * @author Andreas Glaser
     */
    public function testGetRandomValue()
    {
        $testArray = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ];

        $this->assertTrue(in_array(ArrayHelper::getRandomValue($testArray), $testArray));
    }

    public function testRemoveFirstIndex()
    {
        $this->todo();
    }

    /**
     * @author Andreas Glaser
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

        $this->assertEquals(
            [
                0 => '1',
                2 => true,
                3 => false,
                4 => null,
            ],
            ArrayHelper::removeByValue($array, 2)
        );

        $this->assertEquals(
            [
                0 => '1',
                1 => 2,
                2 => true,
                3 => false,
                4 => null,
            ],
            ArrayHelper::removeByValue($array, 1, true)
        );

        $this->assertEquals(
            [
                1 => 2,
                2 => true,
                3 => false,
                4 => null,
            ],
            ArrayHelper::removeByValue($array, 1, false)
        );
    }

    public function testKeysCamelToUnderscore()
    {
        $this->todo();
    }

    public function testUnsetEmptyValues()
    {
        $this->todo();
    }

    public function testImplodeIgnoreEmpty()
    {
        $this->todo();
    }

    /**
     * @author Andreas Glaser
     */
    public function testImplodeKeys()
    {
        $this->assertEquals(
            'rat,mouse,tiger,0,1,2',
            ArrayHelper::implodeKeys(',', ['rat' => 1, 'mouse' => 2, 'tiger' => 3, null, [], 1])
        );
    }

    /**
     * @author Andreas Glaser
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

        $this->assertEquals(8, count($explodedArray));
        $this->assertTrue(($expectedArray === $explodedArray));
    }

    public function testValueToUpper()
    {
        $this->todo();
    }

    public function testIsAssoc()
    {
        $this->todo();
    }

    public function testAssocIndexesExist()
    {
        $this->todo();
    }

    /**
     * @author Andreas Glaser
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

        $this->assertEquals(
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

        $this->assertEquals(
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

        $this->assertEquals(
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

        $this->assertEquals(
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
     * @author Andreas Glaser
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

        $this->assertEquals(
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

        $this->assertEquals(
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

        $this->assertEquals(
            [
                'assoc1' => 'value1',
                'assoc2' => 'overwritten',
                'assoc4' => [],
                0        => 'value4',
            ],
            ArrayHelper::merge($array1, ['assoc2' => 'overwritten'])
        );

        $this->assertEquals(
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
                0        => 'value4',
            ],
            ArrayHelper::merge($array1, ['assoc4' => ['cheese', 'abc' => 'tasty']])
        );

        $this->setExpectedException('\InvalidArgumentException', 'Argument 2 is not an array');
        ArrayHelper::merge(['abc'], 123);
    }
}
