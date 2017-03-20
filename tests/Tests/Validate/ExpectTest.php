<?php

namespace AndreasGlaser\Helpers\Tests\Validate;

use AndreasGlaser\Helpers\Tests\BaseTest;
use AndreasGlaser\Helpers\Validate\Expect;

/**
 * Class ExpectTest
 *
 * @package AndreasGlaser\Helpers\Tests\Validate
 * @author  Andreas Glaser
 */
class ExpectTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function testInt()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "integer", "string" given');
        Expect::int('22');
    }

    /**
     * @author Andreas Glaser
     */
    public function testFloat()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "float", "integer" given');
        Expect::float(2);
    }

    /**
     * @author Andreas Glaser
     */
    public function testNumeric()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "numeric", "string" given');
        Expect::numeric('0b10100111001');
    }

    /**
     * @author Andreas Glaser
     */
    public function testBool()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "boolean", "integer" given');
        Expect::bool(1);
    }

    /**
     * @author Andreas Glaser
     */
    public function testStr()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "string", "boolean" given');
        Expect::str(true);
    }

    /**
     * @author Andreas Glaser
     */
    public function testArr()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "array", "stdClass" given');
        Expect::arr(new \stdClass());
    }

    /**
     * @author Andreas Glaser
     */
    public function testObj()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "object", "array" given');
        Expect::obj([]);
    }

    /**
     * @author Andreas Glaser
     */
    public function testRes()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "resource", "boolean" given');
        Expect::res(false);
    }

    /**
     * @author Andreas Glaser
     */
    public function testIsCallable()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "callable", "string" given');
        Expect::isCallable('hello');
    }

    /**
     * @author Andreas Glaser
     */
    public function testScalar()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "scalar", "stdClass" given');
        Expect::scalar(new \stdClass());
    }

    /**
     * @author Andreas Glaser
     */
    public function testNull()
    {
        $this->expectException('\AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException');
        $this->expectExceptionMessage('Expected argument of type "null", "string" given');
        Expect::null('');
    }
}