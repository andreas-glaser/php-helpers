<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\ArrayHelper;

/**
 * Class ArrayHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
class ArrayHelperTest extends \PHPUnit_Framework_TestCase
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
    public function testGetRandomValue()
    {
        $this->assertTrue(in_array(ArrayHelper::getRandomValue($this->arrayAssoc), $this->arrayAssoc));
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

        $this->assertEquals([
            'test'   => 'Bye',
            'index2' => [
                'index3' => [
                    'index4' => 'XYZ',
                    'index5' => 'Something',
                ],
            ],
        ], ArrayHelper::setByPath($myArray, 'test', 'Bye'));

        $this->assertEquals([
            'test'   => 'Hello',
            'index2' => [
                'index3' => [
                    'index4' => 'XYZ',
                    'index5' => 'Something',
                    'test'   => 'Cheese',
                ],
            ],
        ], ArrayHelper::setByPath($myArray, 'index2.index3.test', 'Cheese'));

        $this->setExpectedException('\RuntimeException', 'Array index "test" exists already and is not of type "array"');

        $this->assertEquals([
            'test'   => 'Hello',
            'index2' => [
                'index3' => [
                    'index4' => 'XYZ',
                    'index5' => 'Something',
                    'test'   => 'Cheese',
                ],
            ],
        ], ArrayHelper::setByPath($myArray, 'test.abc.something', 'Cheese'));
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

        $this->assertEquals([
            'jam',
            'Mustard',
            'sauce',
            'sweets' => [
                'MARS',
                'curly wurly',
                'ding dong',
                'jam',
            ],
        ], ArrayHelper::replaceValue($testArray, 'honey', 'jam', true, true));

        $this->assertEquals([
            'jam',
            'Mustard',
            'sauce',
            'sweets' => [
                'MARS',
                'curly wurly',
                'ding dong',
                'honey',
            ],
        ], ArrayHelper::replaceValue($testArray, 'honey', 'jam', false, true));

        $this->assertEquals([
            'honey',
            'Mustard',
            'sauce',
            'sweets' => [
                'MARS',
                'curly wurly',
                'ding dong',
                'honey',
            ],
        ], ArrayHelper::replaceValue($testArray, 'HONEY', 'jam', true, true));

        $this->assertEquals([
            'jam',
            'Mustard',
            'sauce',
            'sweets' => [
                'MARS',
                'curly wurly',
                'ding dong',
                'jam',
            ],
        ], ArrayHelper::replaceValue($testArray, 'HONEY', 'jam', true, false));
    }

    /**
     * @author Andreas Glaser
     */
    public function testImplodeKeys()
    {
        $this->assertEquals('rat,mouse,tiger,0,1,2', ArrayHelper::implodeKeys(',', ['rat' => 1, 'mouse' => 2, 'tiger' => 3, null, [], 1]));
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

        $this->assertEquals([
            0 => '1',
            2 => true,
            3 => false,
            4 => null,
        ], ArrayHelper::removeByValue($array, 2));

        $this->assertEquals([
            0 => '1',
            1 => 2,
            2 => true,
            3 => false,
            4 => null,
        ], ArrayHelper::removeByValue($array, 1, true));

        $this->assertEquals([
            1 => 2,
            2 => true,
            3 => false,
            4 => null,
        ], ArrayHelper::removeByValue($array, 1, false));
    }
}
