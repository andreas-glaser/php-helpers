<?php

namespace AndreasGlaser\Helpers\Tests\Validate;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Validate\Expect;
use AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException;

/**
 * ExpectTest provides unit tests for the Expect class.
 *
 * This class tests type validation methods:
 * - Basic types (int, float, string, bool)
 * - Complex types (array, object, resource)
 * - Special types (numeric, callable, scalar, null)
 * - Built-in PHP types (countable, iterable, finite, infinite, nan)
 * 
 * Each method is tested with valid inputs, invalid inputs, edge cases,
 * and proper exception handling with correct error messages.
 */
class ExpectTest extends TestCase
{
    // ========================================
    // Tests for int() method
    // ========================================

    /**
     * Tests the int() method with valid integer values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @return void
     */
    public function testIntWithValidInteger()
    {
        $this->expectNotToPerformAssertions();
        Expect::int(42);
        Expect::int(0);
        Expect::int(-123);
        Expect::int(PHP_INT_MAX);
        Expect::int(PHP_INT_MIN);
    }

    /**
     * Tests the int() method with float values.
     * Verifies that UnexpectedTypeException is thrown for float input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @return void
     */
    public function testIntWithFloat()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "integer", "double" given');
        Expect::int(42.0);
    }

    /**
     * Tests the int() method with string values.
     * Verifies that UnexpectedTypeException is thrown for string input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @return void
     */
    public function testIntWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "integer", "string" given');
        Expect::int('42');
    }

    /**
     * Tests the int() method with numeric string values.
     * Verifies that UnexpectedTypeException is thrown for numeric string input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @return void
     */
    public function testIntWithNumericString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "integer", "string" given');
        Expect::int('123');
    }

    /**
     * Tests the int() method with boolean values.
     * Verifies that UnexpectedTypeException is thrown for boolean input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @return void
     */
    public function testIntWithBoolean()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "integer", "boolean" given');
        Expect::int(true);
    }

    /**
     * Tests the int() method with array values.
     * Verifies that UnexpectedTypeException is thrown for array input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @return void
     */
    public function testIntWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "integer", "array" given');
        Expect::int([]);
    }

    /**
     * Tests the int() method with null values.
     * Verifies that UnexpectedTypeException is thrown for null input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @return void
     */
    public function testIntWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "integer", "NULL" given');
        Expect::int(null);
    }

  
    /**
     * Tests the float() method with valid float values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::float
     * @return void
     */
    public function testFloatWithValidFloat()
    {
        $this->expectNotToPerformAssertions();
        Expect::float(42.5);
        Expect::float(0.0);
        Expect::float(-123.456);
        Expect::float(PHP_FLOAT_MAX);
        Expect::float(PHP_FLOAT_MIN);
        Expect::float(INF);
        Expect::float(-INF);
    }

    /**
     * Tests the float() method with NaN values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::float
     * @return void
     */
    public function testFloatWithNaN()
    {
        $this->expectNotToPerformAssertions();
        Expect::float(NAN);
    }

    /**
     * Tests the float() method with integer values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::float
     * @return void
     */
    public function testFloatWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "float", "integer" given');
        Expect::float(42);
    }

    /**
     * Tests the float() method with string values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::float
     * @return void
     */
    public function testFloatWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "float", "string" given');
        Expect::float('42.5');
    }

    /**
     * Tests the float() method with boolean values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::float
     * @return void
     */
    public function testFloatWithBoolean()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "float", "boolean" given');
        Expect::float(false);
    }

    // ========================================
    // Tests for numeric() method
    // ========================================

    /**
     * Tests the numeric() method with valid numeric values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::numeric
     * @return void
     */
    public function testNumericWithValidNumeric()
    {
        $this->expectNotToPerformAssertions();
        Expect::numeric(42);
        Expect::numeric(42.5);
        Expect::numeric('42');
        Expect::numeric('42.5');
        Expect::numeric('-123');
        Expect::numeric('0');
        Expect::numeric('0.0');
        Expect::numeric('1e10');
        // Note: hexadecimal, binary and octal string formats are not supported by is_numeric()
    }

    /**
     * Tests the numeric() method with non-numeric string. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::numeric
     * @return void
     */
    public function testNumericWithNonNumeric()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "numeric", "string" given');
        Expect::numeric('not a number');
    }

    /**
     * Tests the numeric() method with boolean values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::numeric
     * @return void
     */
    public function testNumericWithBoolean()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "numeric", "boolean" given');
        Expect::numeric(true);
    }

    /**
     * Tests the numeric() method with array values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::numeric
     * @return void
     */
    public function testNumericWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "numeric", "array" given');
        Expect::numeric([1, 2, 3]);
    }

    /**
     * Tests the numeric() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::numeric
     * @return void
     */
    public function testNumericWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "numeric", "NULL" given');
        Expect::numeric(null);
    }

    // ========================================
    // Tests for bool() method
    // ========================================

    /**
     * Tests the bool() method with valid boolean values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::bool
     * @return void
     */
    public function testBoolWithValidBoolean()
    {
        $this->expectNotToPerformAssertions();
        Expect::bool(true);
        Expect::bool(false);
    }

    /**
     * Tests the bool() method with integer values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::bool
     * @return void
     */
    public function testBoolWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "boolean", "integer" given');
        Expect::bool(1);
    }

    /**
     * Tests the bool() method with zero value. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::bool
     * @return void
     */
    public function testBoolWithZero()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "boolean", "integer" given');
        Expect::bool(0);
    }

    /**
     * Tests the bool() method with string values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::bool
     * @return void
     */
    public function testBoolWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "boolean", "string" given');
        Expect::bool('true');
    }

    /**
     * Tests the bool() method with empty string. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::bool
     * @return void
     */
    public function testBoolWithEmptyString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "boolean", "string" given');
        Expect::bool('');
    }

    /**
     * Tests the bool() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::bool
     * @return void
     */
    public function testBoolWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "boolean", "NULL" given');
        Expect::bool(null);
    }



    /**
     * Tests the str() method with valid string values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testStrWithValidString()
    {
        $this->expectNotToPerformAssertions();
        Expect::str('hello');
        Expect::str('');
        Expect::str('123');
        Expect::str('true');
        Expect::str('null');
        Expect::str('special chars: !@#$%^&*()');
        Expect::str('unicode: 🚀 ñ ü');
        Expect::str("\n\t\r");
    }

    /**
     * Tests the str() method with integer values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testStrWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "string", "integer" given');
        Expect::str(123);
    }

    /**
     * Tests the str() method with float values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testStrWithFloat()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "string", "double" given');
        Expect::str(123.45);
    }

    /**
     * Tests the str() method with boolean values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testStrWithBoolean()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "string", "boolean" given');
        Expect::str(true);
    }

    /**
     * Tests the str() method with array values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testStrWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "string", "array" given');
        Expect::str(['hello']);
    }

    /**
     * Tests the str() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testStrWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "string", "NULL" given');
        Expect::str(null);
    }


    /**
     * Tests the arr() method with valid array values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::arr
     * @return void
     */
    public function testArrWithValidArray()
    {
        $this->expectNotToPerformAssertions();
        Expect::arr([]);
        Expect::arr([1, 2, 3]);
        Expect::arr(['a' => 1, 'b' => 2]);
        Expect::arr([null, false, '', 0]);
        Expect::arr([[1, 2], [3, 4]]);
        Expect::arr(range(1, 100));
    }

    /**
     * Tests the arr() method with string values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::arr
     * @return void
     */
    public function testArrWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "array", "string" given');
        Expect::arr('[]');
    }

    /**
     * Tests the arr() method with object values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::arr
     * @return void
     */
    public function testArrWithObject()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "array", "stdClass" given');
        Expect::arr(new \stdClass());
    }

    /**
     * Tests the arr() method with integer values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::arr
     * @return void
     */
    public function testArrWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "array", "integer" given');
        Expect::arr(123);
    }

    /**
     * Tests the arr() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::arr
     * @return void
     */
    public function testArrWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "array", "NULL" given');
        Expect::arr(null);
    }


    /**
     * Tests the obj() method with valid object values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::obj
     * @return void
     */
    public function testObjWithValidObject()
    {
        $this->expectNotToPerformAssertions();
        Expect::obj(new \stdClass());
        Expect::obj(new \DateTime());
        Expect::obj(new \Exception());
        Expect::obj($this);
        
        // Anonymous class
        $anonymousObj = new class {
            public $prop = 'value';
        };
        Expect::obj($anonymousObj);
    }

    /**
     * Tests the obj() method with array values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::obj
     * @return void
     */
    public function testObjWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "object", "array" given');
        Expect::obj([]);
    }

    /**
     * Tests the obj() method with string values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::obj
     * @return void
     */
    public function testObjWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "object", "string" given');
        Expect::obj('stdClass');
    }

    /**
     * Tests the obj() method with integer values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::obj
     * @return void
     */
    public function testObjWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "object", "integer" given');
        Expect::obj(123);
    }

    /**
     * Tests the obj() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::obj
     * @return void
     */
    public function testObjWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "object", "NULL" given');
        Expect::obj(null);
    }

    // ========================================
    // Tests for res() method
    // ========================================

    /**
     * Tests the res() method with valid resource values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::res
     * @return void
     */
    public function testResWithValidResource()
    {
        $this->expectNotToPerformAssertions();
        
        $fileResource = fopen('php://memory', 'r');
        Expect::res($fileResource);
        fclose($fileResource);
        
        // Note: In PHP 8+, curl_init() returns CurlHandle object, not resource
        // So we'll skip the curl test for now
        
        $streamContext = stream_context_create();
        Expect::res($streamContext);
    }

    /**
     * Tests the res() method with closed resource. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::res
     * @return void
     */
    public function testResWithClosedResource()
    {
        $fileResource = fopen('php://memory', 'r');
        fclose($fileResource);
        
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "resource", "resource (closed)" given');
        Expect::res($fileResource);
    }

    /**
     * Tests the res() method with string values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::res
     * @return void
     */
    public function testResWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "resource", "string" given');
        Expect::res('resource');
    }

    /**
     * Tests the res() method with array values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::res
     * @return void
     */
    public function testResWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "resource", "array" given');
        Expect::res([]);
    }

    /**
     * Tests the res() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::res
     * @return void
     */
    public function testResWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "resource", "NULL" given');
        Expect::res(null);
    }



    /**
     * Tests the isCallable() method with valid callable values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::isCallable
     * @return void
     */
    public function testIsCallableWithValidCallable()
    {
        $this->expectNotToPerformAssertions();
        
        // Function name as string
        Expect::isCallable('strlen');
        Expect::isCallable('array_map');
        
        // Closure
        $closure = function() { return 'test'; };
        Expect::isCallable($closure);
        
        // Array callable (static method)
        Expect::isCallable(['DateTime', 'createFromFormat']);
        
        // Array callable (instance method)
        $obj = new \DateTime();
        Expect::isCallable([$obj, 'format']);
        
        // Invokable object
        $invokable = new class {
            public function __invoke() { return 'invoked'; }
        };
        Expect::isCallable($invokable);
        
        // Static method as string
        Expect::isCallable('DateTime::createFromFormat');
    }

    /**
     * Tests the isCallable() method with string values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::isCallable
     * @return void
     */
    public function testIsCallableWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "callable", "string" given');
        Expect::isCallable('not_a_function');
    }

    /**
     * Tests the isCallable() method with integer values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::isCallable
     * @return void
     */
    public function testIsCallableWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "callable", "integer" given');
        Expect::isCallable(123);
    }

    /**
     * Tests the isCallable() method with array values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::isCallable
     * @return void
     */
    public function testIsCallableWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "callable", "array" given');
        Expect::isCallable(['not', 'callable']);
    }

    /**
     * Tests the isCallable() method with object values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::isCallable
     * @return void
     */
    public function testIsCallableWithObject()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "callable", "stdClass" given');
        Expect::isCallable(new \stdClass());
    }

    /**
     * Tests the isCallable() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::isCallable
     * @return void
     */
    public function testIsCallableWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "callable", "NULL" given');
        Expect::isCallable(null);
    }



    /**
     * Tests the scalar() method with valid scalar values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::scalar
     * @return void
     */
    public function testScalarWithValidScalar()
    {
        $this->expectNotToPerformAssertions();
        
        // Integers
        Expect::scalar(42);
        Expect::scalar(0);
        Expect::scalar(-123);
        
        // Floats
        Expect::scalar(42.5);
        Expect::scalar(0.0);
        Expect::scalar(-123.456);
        
        // Strings
        Expect::scalar('hello');
        Expect::scalar('');
        Expect::scalar('123');
        
        // Booleans
        Expect::scalar(true);
        Expect::scalar(false);
    }

    /**
     * Tests the scalar() method with array values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::scalar
     * @return void
     */
    public function testScalarWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "scalar", "array" given');
        Expect::scalar([]);
    }

    /**
     * Tests the scalar() method with object values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::scalar
     * @return void
     */
    public function testScalarWithObject()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "scalar", "stdClass" given');
        Expect::scalar(new \stdClass());
    }

    /**
     * Tests the scalar() method with resource values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::scalar
     * @return void
     */
    public function testScalarWithResource()
    {
        $resource = fopen('php://memory', 'r');
        
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "scalar", "resource" given');
        Expect::scalar($resource);
        
        fclose($resource);
    }

    /**
     * Tests the scalar() method with null values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::scalar
     * @return void
     */
    public function testScalarWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "scalar", "NULL" given');
        Expect::scalar(null);
    }



    /**
     * Tests the null() method with valid null value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::null
     * @return void
     */
    public function testNullWithValidNull()
    {
        $this->expectNotToPerformAssertions();
        Expect::null(null);
    }

    /**
     * Tests the null() method with integer values. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::null
     * @return void
     */
    public function testNullWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "null", "integer" given');
        Expect::null(0);
    }

    /**
     * Tests the null() method with empty string. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::null
     * @return void
     */
    public function testNullWithEmptyString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "null", "string" given');
        Expect::null('');
    }

    /**
     * Tests the null() method with false value. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::null
     * @return void
     */
    public function testNullWithFalse()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "null", "boolean" given');
        Expect::null(false);
    }

    /**
     * Tests the null() method with empty array. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::null
     * @return void
     */
    public function testNullWithEmptyArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "null", "array" given');
        Expect::null([]);
    }

    /**
     * Tests the null() method with string value. Expects exception.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::null
     * @return void
     */
    public function testNullWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "null", "string" given');
        Expect::null('null');
    }


    /**
     * Tests validation methods with very large numbers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @covers \AndreasGlaser\Helpers\Validate\Expect::float
     * @covers \AndreasGlaser\Helpers\Validate\Expect::numeric
     * @return void
     */
    public function testWithVeryLargeNumbers()
    {
        $this->expectNotToPerformAssertions();
        
        Expect::int(PHP_INT_MAX);
        Expect::int(PHP_INT_MIN);
        Expect::float(PHP_FLOAT_MAX);
        Expect::float(PHP_FLOAT_MIN);
        
        Expect::numeric(PHP_INT_MAX);
        Expect::numeric(PHP_FLOAT_MAX);
        Expect::numeric((string)PHP_INT_MAX);
    }

    /**
     * Tests validation methods with special float values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::float
     * @covers \AndreasGlaser\Helpers\Validate\Expect::numeric
     * @return void
     */
    public function testWithSpecialFloats()
    {
        $this->expectNotToPerformAssertions();
        
        Expect::float(INF);
        Expect::float(-INF);
        Expect::float(NAN);
        
        Expect::numeric(INF);
        Expect::numeric(-INF);
        Expect::numeric(NAN);
    }

    /**
     * Tests validation methods with unicode strings.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testWithUnicodeStrings()
    {
        $this->expectNotToPerformAssertions();
        
        Expect::str('Hello 世界');
        Expect::str('🚀🌟💫');
        Expect::str('Ñoño niño');
        Expect::str('Здравствуй мир');
        Expect::str('مرحبا بالعالم');
    }

    /**
     * Tests validation methods with complex arrays.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::arr
     * @return void
     */
    public function testWithComplexArrays()
    {
        $this->expectNotToPerformAssertions();
        
        $complexArray = [
            'nested' => [
                'deep' => [
                    'value' => 42
                ]
            ],
            'mixed' => [1, 'two', 3.0, true, null],
            'objects' => [new \stdClass(), new \DateTime()],
            'callable' => [function() { return 'test'; }]
        ];
        
        Expect::arr($complexArray);
    }

    /**
     * Tests exception message format validation.
     * Verifies that exceptions contain proper type information.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::int
     * @covers \AndreasGlaser\Helpers\Validate\Expect::obj
     * @return void
     */
    public function testExceptionMessageFormat()
    {
        try {
            Expect::int('not an integer');
            $this->fail('Expected UnexpectedTypeException was not thrown');
        } catch (UnexpectedTypeException $e) {
            $this->assertStringContainsString('Expected argument of type "integer"', $e->getMessage());
            $this->assertStringContainsString('"string" given', $e->getMessage());
        }
        
        try {
            Expect::obj([]);
            $this->fail('Expected UnexpectedTypeException was not thrown');
        } catch (UnexpectedTypeException $e) {
            $this->assertStringContainsString('Expected argument of type "object"', $e->getMessage());
            $this->assertStringContainsString('"array" given', $e->getMessage());
        }
    }

    /**
     * Tests exception handling with custom object.
     * Verifies proper class name reporting in exceptions.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::str
     * @return void
     */
    public function testExceptionWithCustomObject()
    {
        $customObject = new class {
            public function __toString() {
                return 'CustomObject';
            }
        };
        
        try {
            Expect::str($customObject);
            $this->fail('Expected UnexpectedTypeException was not thrown');
        } catch (UnexpectedTypeException $e) {
            $this->assertStringContainsString('Expected argument of type "string"', $e->getMessage());
            // The exception should show the class name, not the string representation
            $this->assertStringContainsString('class@anonymous', $e->getMessage());
        }
    }



    /**
     * Tests the countable() method with valid countable values.
     * Tests arrays and objects implementing Countable interface.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::countable
     * @return void
     */
    public function testCountableWithValidCountable()
    {
        $this->expectNotToPerformAssertions();
        
        // Arrays are countable
        Expect::countable([]);
        Expect::countable([1, 2, 3]);
        Expect::countable(['a' => 1, 'b' => 2]);
        
        // Objects implementing Countable
        $countableObject = new class implements \Countable {
            public function count(): int {
                return 5;
            }
        };
        Expect::countable($countableObject);
        
        // Built-in countable objects
        Expect::countable(new \ArrayObject([1, 2, 3]));
        Expect::countable(new \SplFixedArray(3));
    }

    /**
     * Tests the countable() method with string values.
     * Verifies that UnexpectedTypeException is thrown for string input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::countable
     * @return void
     */
    public function testCountableWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "countable", "string" given');
        Expect::countable('hello');
    }

    public function testCountableWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "countable", "integer" given');
        Expect::countable(42);
    }

    public function testCountableWithObject()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "countable", "stdClass" given');
        Expect::countable(new \stdClass());
    }

    public function testCountableWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "countable", "NULL" given');
        Expect::countable(null);
    }



    /**
     * Tests the iterable() method with valid iterable values.
     * Tests arrays, objects implementing Traversable, and generators.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::iterable
     * @return void
     */
    public function testIterableWithValidIterable()
    {
        $this->expectNotToPerformAssertions();
        
        // Arrays are iterable
        Expect::iterable([]);
        Expect::iterable([1, 2, 3]);
        Expect::iterable(['a' => 1, 'b' => 2]);
        
        // Objects implementing Traversable
        Expect::iterable(new \ArrayObject([1, 2, 3]));
        Expect::iterable(new \ArrayIterator([1, 2, 3]));
        
        // Generators are iterable
        $generator = function() {
            yield 1;
            yield 2;
            yield 3;
        };
        Expect::iterable($generator());
        
        // Built-in iterable objects
        Expect::iterable(new \DirectoryIterator('.'));
    }

    public function testIterableWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "iterable", "string" given');
        Expect::iterable('hello');
    }

    public function testIterableWithInteger()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "iterable", "integer" given');
        Expect::iterable(42);
    }

    public function testIterableWithObject()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "iterable", "stdClass" given');
        Expect::iterable(new \stdClass());
    }

    public function testIterableWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "iterable", "NULL" given');
        Expect::iterable(null);
    }


    /**
     * Tests the finite() method with valid finite numbers.
     * Tests integers and floats that are not infinite or NaN.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::finite
     * @return void
     */
    public function testFiniteWithValidFinite()
    {
        $this->expectNotToPerformAssertions();
        
        // Regular integers
        Expect::finite(42);
        Expect::finite(0);
        Expect::finite(-123);
        Expect::finite(PHP_INT_MAX);
        Expect::finite(PHP_INT_MIN);
        
        // Regular floats
        Expect::finite(42.5);
        Expect::finite(0.0);
        Expect::finite(-123.456);
        Expect::finite(PHP_FLOAT_MAX);
        Expect::finite(PHP_FLOAT_MIN);
        
        // Very small numbers
        Expect::finite(1e-10);
        Expect::finite(-1e-10);
    }

    /**
     * Tests the finite() method with infinite values.
     * Verifies that UnexpectedTypeException is thrown for infinite input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::finite
     * @return void
     */
    public function testFiniteWithInfinite()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "finite number", "double" given');
        Expect::finite(INF);
    }

    public function testFiniteWithNegativeInfinite()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "finite number", "double" given');
        Expect::finite(-INF);
    }

    public function testFiniteWithNaN()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "finite number", "double" given');
        Expect::finite(NAN);
    }

    public function testFiniteWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "finite number", "string" given');
        Expect::finite('42');
    }

    public function testFiniteWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "finite number", "array" given');
        Expect::finite([]);
    }

    public function testFiniteWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "finite number", "NULL" given');
        Expect::finite(null);
    }



    public function testInfiniteWithValidInfinite()
    {
        $this->expectNotToPerformAssertions();
        
        Expect::infinite(INF);
        Expect::infinite(-INF);
        
        // Mathematical operations that result in infinity (safe operations)
        Expect::infinite(log(0)); // log(0) = -INF
    }

    public function testInfiniteWithFiniteNumber()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "infinite number", "integer" given');
        Expect::infinite(42);
    }

    public function testInfiniteWithFiniteFloat()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "infinite number", "double" given');
        Expect::infinite(42.5);
    }

    public function testInfiniteWithNaN()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "infinite number", "double" given');
        Expect::infinite(NAN);
    }

    public function testInfiniteWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "infinite number", "string" given');
        Expect::infinite('INF');
    }

    public function testInfiniteWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "infinite number", "array" given');
        Expect::infinite([]);
    }

    public function testInfiniteWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "infinite number", "NULL" given');
        Expect::infinite(null);
    }



    public function testNanWithValidNaN()
    {
        $this->expectNotToPerformAssertions();
        
        Expect::nan(NAN);
        
        // Mathematical operations that result in NaN (safe operations)
        Expect::nan(sqrt(-1));
        Expect::nan(acos(2));
    }

    public function testNanWithFiniteNumber()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "NaN", "integer" given');
        Expect::nan(42);
    }

    public function testNanWithFiniteFloat()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "NaN", "double" given');
        Expect::nan(42.5);
    }

    public function testNanWithInfinite()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "NaN", "double" given');
        Expect::nan(INF);
    }

    public function testNanWithString()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "NaN", "string" given');
        Expect::nan('NaN');
    }

    public function testNanWithArray()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "NaN", "array" given');
        Expect::nan([]);
    }

    public function testNanWithNull()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "NaN", "NULL" given');
        Expect::nan(null);
    }


    /**
     * Tests new validation methods with complex scenarios.
     * Tests edge cases and mathematical operations for the new built-in type methods.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Validate\Expect::countable
     * @covers \AndreasGlaser\Helpers\Validate\Expect::iterable
     * @covers \AndreasGlaser\Helpers\Validate\Expect::finite
     * @covers \AndreasGlaser\Helpers\Validate\Expect::infinite
     * @covers \AndreasGlaser\Helpers\Validate\Expect::nan
     * @return void
     */
    public function testNewMethodsWithComplexScenarios()
    {
        $this->expectNotToPerformAssertions();
        
        // Test countable with complex arrays
        $complexArray = [
            'nested' => ['deep' => ['value' => 42]],
            'objects' => [new \stdClass(), new \DateTime()]
        ];
        Expect::countable($complexArray);
        
        // Test iterable with nested generators
        $nestedGenerator = function() {
            yield from [1, 2, 3];
            yield from range(4, 6);
        };
        Expect::iterable($nestedGenerator());
        
        // Test finite with mathematical operations
        Expect::finite(pow(2, 10));
        Expect::finite(sin(M_PI));
        Expect::finite(cos(M_PI / 2));
        
        // Test mathematical edge cases (safe operations)
        Expect::infinite(log(0)); // -INF
        Expect::nan(sqrt(-1)); // NaN
    }
} 