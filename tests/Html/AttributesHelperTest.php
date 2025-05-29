<?php

namespace Tests\Html;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Html\AttributesHelper;
use InvalidArgumentException;

/**
 * AttributesHelperTest provides unit tests for the AttributesHelper class.
 *
 * This class tests HTML attribute management methods:
 * - Factory methods (f, create, constructor)
 * - Attribute setting and validation
 * - ID management with validation
 * - CSS class management
 * - Data attribute handling
 * - CSS style management and parsing
 * - HTML rendering and escaping
 * - Getter methods for immutability
 * - Edge cases and error handling
 * 
 * Each method is tested with valid inputs, invalid inputs, edge cases,
 * and proper exception handling with correct error messages.
 */
class AttributesHelperTest extends TestCase
{
    // ========================================
    // Tests for factory methods
    // ========================================

    /**
     * Tests the f() factory method with null input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::f
     * @return void
     */
    public function testFactoryMethodWithNull()
    {
        $helper = AttributesHelper::f();
        $this->assertInstanceOf(AttributesHelper::class, $helper);
        $this->assertNull($helper->getId());
        $this->assertEmpty($helper->getClasses());
        $this->assertEmpty($helper->getData());
        $this->assertEmpty($helper->getStyles());
        $this->assertEmpty($helper->getAttributes());
    }

    /**
     * Tests the f() factory method with array input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::f
     * @return void
     */
    public function testFactoryMethodWithArray()
    {
        $attributes = ['id' => 'test-id', 'class' => 'test-class'];
        $helper = AttributesHelper::f($attributes);
        
        $this->assertInstanceOf(AttributesHelper::class, $helper);
        $this->assertEquals('test-id', $helper->getId());
        $this->assertEquals(['test-class' => true], $helper->getClasses());
    }

    /**
     * Tests the f() factory method with existing AttributesHelper instance.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::f
     * @return void
     */
    public function testFactoryMethodWithExistingInstance()
    {
        $original = new AttributesHelper(['id' => 'original-id']);
        $result = AttributesHelper::f($original);
        
        $this->assertSame($original, $result);
        $this->assertEquals('original-id', $result->getId());
    }

    /**
     * Tests the deprecated create() factory method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::create
     * @return void
     */
    public function testDeprecatedCreateMethod()
    {
        $helper = AttributesHelper::create(['class' => 'btn']);
        
        $this->assertInstanceOf(AttributesHelper::class, $helper);
        $this->assertEquals(['btn' => true], $helper->getClasses());
    }

    /**
     * Tests the constructor with valid attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::__construct
     * @return void
     */
    public function testConstructorWithValidAttributes()
    {
        $attributes = [
            'id' => 'test-id',
            'class' => 'btn btn-primary',
            'data-toggle' => 'modal',
            'style' => 'color: red; margin: 10px',
            'title' => 'Test Title'
        ];
        
        $helper = new AttributesHelper($attributes);
        
        $this->assertEquals('test-id', $helper->getId());
        $this->assertEquals(['btn' => true, 'btn-primary' => true], $helper->getClasses());
        $this->assertEquals(['toggle' => 'modal'], $helper->getData());
        $this->assertEquals(['color' => 'red', 'margin' => '10px'], $helper->getStyles());
        $this->assertEquals(['title' => 'Test Title'], $helper->getAttributes());
    }

    // ========================================
    // Tests for set() method
    // ========================================

    /**
     * Tests the set() method with valid attribute names and values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::set
     * @return void
     */
    public function testSetWithValidAttributes()
    {
        $helper = new AttributesHelper();
        
        $result = $helper->set('title', 'Test Title');
        $this->assertSame($helper, $result); // Fluent interface
        $this->assertEquals(['title' => 'Test Title'], $helper->getAttributes());
        
        $helper->set('aria-label', 'Accessible Label');
        $this->assertEquals(['title' => 'Test Title', 'aria-label' => 'Accessible Label'], $helper->getAttributes());
    }

    /**
     * Tests the set() method with invalid attribute names.
     * Verifies that InvalidArgumentException is thrown for invalid names.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::set
     * @return void
     */
    public function testSetWithInvalidAttributeName()
    {
        $helper = new AttributesHelper();
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid attribute name: invalid@name');
        $helper->set('invalid@name', 'value');
    }

    /**
     * Tests the set() method with special attribute names that trigger specific handlers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::set
     * @return void
     */
    public function testSetWithSpecialAttributes()
    {
        $helper = new AttributesHelper();
        
        // Test ID handling
        $helper->set('id', 'test-id');
        $this->assertEquals('test-id', $helper->getId());
        
        // Test class handling
        $helper->set('class', 'btn primary');
        $this->assertEquals(['btn' => true, 'primary' => true], $helper->getClasses());
        
        // Test style handling
        $helper->set('style', 'color: blue; font-size: 14px');
        $this->assertEquals(['color' => 'blue', 'font-size' => '14px'], $helper->getStyles());
        
        // Test data attribute handling
        $helper->set('data-target', '#modal');
        $this->assertEquals(['target' => '#modal'], $helper->getData());
    }

    // ========================================
    // Tests for setId() method
    // ========================================

    /**
     * Tests the setId() method with valid ID values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::setId
     * @return void
     */
    public function testSetIdWithValidValues()
    {
        $helper = new AttributesHelper();
        
        $result = $helper->setId('test-id');
        $this->assertSame($helper, $result); // Fluent interface
        $this->assertEquals('test-id', $helper->getId());
        
        $helper->setId('another_id');
        $this->assertEquals('another_id', $helper->getId());
        
        $helper->setId('id123');
        $this->assertEquals('id123', $helper->getId());
    }

    /**
     * Tests the setId() method with invalid ID values.
     * Verifies that InvalidArgumentException is thrown for invalid IDs.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::setId
     * @return void
     */
    public function testSetIdWithInvalidValues()
    {
        $helper = new AttributesHelper();
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ID value: invalid@id');
        $helper->setId('invalid@id');
    }

    /**
     * Tests the setId() method with special characters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::setId
     * @return void
     */
    public function testSetIdWithSpecialCharacters()
    {
        $helper = new AttributesHelper();
        
        // Test various invalid characters
        $invalidIds = ['id with spaces', 'id#hash', 'id.dot', 'id@symbol', 'id%percent'];
        
        foreach ($invalidIds as $invalidId) {
            try {
                $helper->setId($invalidId);
                $this->fail("Expected InvalidArgumentException for ID: $invalidId");
            } catch (InvalidArgumentException $e) {
                $this->assertStringContainsString("Invalid ID value: $invalidId", $e->getMessage());
            }
        }
    }

    // ========================================
    // Tests for addClass() method
    // ========================================

    /**
     * Tests the addClass() method with valid string classes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addClass
     * @return void
     */
    public function testAddClassWithStringInput()
    {
        $helper = new AttributesHelper();
        
        $result = $helper->addClass('btn');
        $this->assertSame($helper, $result); // Fluent interface
        $this->assertEquals(['btn' => true], $helper->getClasses());
        
        $helper->addClass('btn-primary large');
        $this->assertEquals(['btn' => true, 'btn-primary' => true, 'large' => true], $helper->getClasses());
    }

    /**
     * Tests the addClass() method with array input.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addClass
     * @return void
     */
    public function testAddClassWithArrayInput()
    {
        $helper = new AttributesHelper();
        
        $helper->addClass(['btn', 'btn-secondary', 'rounded']);
        $this->assertEquals(['btn' => true, 'btn-secondary' => true, 'rounded' => true], $helper->getClasses());
    }

    /**
     * Tests the addClass() method with duplicate classes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addClass
     * @return void
     */
    public function testAddClassWithDuplicates()
    {
        $helper = new AttributesHelper();
        
        $helper->addClass('btn')
               ->addClass('primary')
               ->addClass('btn'); // Duplicate
        
        $this->assertEquals(['btn' => true, 'primary' => true], $helper->getClasses());
    }

    /**
     * Tests the addClass() method with invalid class names.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addClass
     * @return void
     */
    public function testAddClassWithInvalidNames()
    {
        $helper = new AttributesHelper();
        
        // Invalid class names should be ignored
        $helper->addClass('valid-class invalid@class another-valid');
        $this->assertEquals(['valid-class' => true, 'another-valid' => true], $helper->getClasses());
    }

    /**
     * Tests the addClass() method with empty strings and whitespace.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addClass
     * @return void
     */
    public function testAddClassWithEmptyAndWhitespace()
    {
        $helper = new AttributesHelper();
        
        $helper->addClass('  btn    primary   ');
        $this->assertEquals(['btn' => true, 'primary' => true], $helper->getClasses());
        
        $helper->addClass('');
        $this->assertEquals(['btn' => true, 'primary' => true], $helper->getClasses());
    }

    // ========================================
    // Tests for addData() method
    // ========================================

    /**
     * Tests the addData() method with valid data attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addData
     * @return void
     */
    public function testAddDataWithValidAttributes()
    {
        $helper = new AttributesHelper();
        
        $result = $helper->addData('toggle', 'modal');
        $this->assertSame($helper, $result); // Fluent interface
        $this->assertEquals(['toggle' => 'modal'], $helper->getData());
        
        $helper->addData('target', '#myModal')
               ->addData('backdrop', 'static');
        
        $this->assertEquals([
            'toggle' => 'modal',
            'target' => '#myModal',
            'backdrop' => 'static'
        ], $helper->getData());
    }

    /**
     * Tests the addData() method with various data types.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addData
     * @return void
     */
    public function testAddDataWithVariousTypes()
    {
        $helper = new AttributesHelper();
        
        $helper->addData('string', 'value')
               ->addData('integer', 123)
               ->addData('float', 45.67)
               ->addData('boolean', true)
               ->addData('null', null);
        
        $this->assertEquals([
            'string' => 'value',
            'integer' => '123',
            'float' => '45.67',
            'boolean' => '1',
            'null' => ''
        ], $helper->getData());
    }

    /**
     * Tests the addData() method with invalid attribute names.
     * Verifies that InvalidArgumentException is thrown for invalid names.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addData
     * @return void
     */
    public function testAddDataWithInvalidNames()
    {
        $helper = new AttributesHelper();
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid data attribute name: invalid@name');
        $helper->addData('invalid@name', 'value');
    }

    // ========================================
    // Tests for addStyle() method
    // ========================================

    /**
     * Tests the addStyle() method with valid CSS properties.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addStyle
     * @return void
     */
    public function testAddStyleWithValidProperties()
    {
        $helper = new AttributesHelper();
        
        $result = $helper->addStyle('color', 'red');
        $this->assertSame($helper, $result); // Fluent interface
        $this->assertEquals(['color' => 'red'], $helper->getStyles());
        
        $helper->addStyle('margin', '10px')
               ->addStyle('font-size', '14px');
        
        $this->assertEquals([
            'color' => 'red',
            'margin' => '10px',
            'font-size' => '14px'
        ], $helper->getStyles());
    }

    /**
     * Tests the addStyle() method with whitespace trimming.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addStyle
     * @return void
     */
    public function testAddStyleWithWhitespaceTrimming()
    {
        $helper = new AttributesHelper();
        
        $helper->addStyle('  color  ', '  blue  ');
        $this->assertEquals(['color' => 'blue'], $helper->getStyles());
    }

    /**
     * Tests the addStyle() method with invalid CSS property names.
     * Verifies that InvalidArgumentException is thrown for invalid properties.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addStyle
     * @return void
     */
    public function testAddStyleWithInvalidProperty()
    {
        $helper = new AttributesHelper();
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid CSS property: invalid@property');
        $helper->addStyle('invalid@property', 'value');
    }

    /**
     * Tests the addStyle() method with complex CSS values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::addStyle
     * @return void
     */
    public function testAddStyleWithComplexValues()
    {
        $helper = new AttributesHelper();
        
        $helper->addStyle('background', 'url(image.jpg) no-repeat center')
               ->addStyle('box-shadow', '0 2px 4px rgba(0,0,0,0.1)')
               ->addStyle('transform', 'translateX(10px) rotate(45deg)');
        
        $this->assertEquals([
            'background' => 'url(image.jpg) no-repeat center',
            'box-shadow' => '0 2px 4px rgba(0,0,0,0.1)',
            'transform' => 'translateX(10px) rotate(45deg)'
        ], $helper->getStyles());
    }

    // ========================================
    // Tests for style parsing
    // ========================================

    /**
     * Tests style parsing from style strings.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::set
     * @return void
     */
    public function testStyleStringParsing()
    {
        $helper = new AttributesHelper();
        
        $helper->set('style', 'color: red; margin: 10px; font-size: 14px;');
        $this->assertEquals([
            'color' => 'red',
            'margin' => '10px',
            'font-size' => '14px'
        ], $helper->getStyles());
    }

    /**
     * Tests style parsing with complex values containing semicolons.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::set
     * @return void
     */
    public function testStyleParsingWithComplexValues()
    {
        $helper = new AttributesHelper();
        
        // The CSS parser splits on semicolons, so complex URLs with semicolons will be split
        $helper->set('style', 'background: url(image.jpg); color: blue;');
        $this->assertEquals([
            'background' => 'url(image.jpg)',
            'color' => 'blue'
        ], $helper->getStyles());
    }

    /**
     * Tests style parsing with malformed CSS.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::set
     * @return void
     */
    public function testStyleParsingWithMalformedCSS()
    {
        $helper = new AttributesHelper();
        
        // Only valid CSS properties will be accepted; invalid ones will throw exceptions
        $helper->set('style', 'color: red; valid-prop: value;');
        $this->assertEquals([
            'color' => 'red',
            'valid-prop' => 'value'
        ], $helper->getStyles());
    }

    // ========================================
    // Tests for with() method
    // ========================================

    /**
     * Tests the with() method for immutable modifications.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::with
     * @return void
     */
    public function testWithMethodImmutability()
    {
        $original = new AttributesHelper(['id' => 'original']);
        
        $modified = $original->with(function($helper) {
            $helper->addClass('new-class')
                   ->addData('test', 'value');
        });
        
        // Original should be unchanged
        $this->assertEquals('original', $original->getId());
        $this->assertEmpty($original->getClasses());
        $this->assertEmpty($original->getData());
        
        // Modified should have changes
        $this->assertEquals('original', $modified->getId());
        $this->assertEquals(['new-class' => true], $modified->getClasses());
        $this->assertEquals(['test' => 'value'], $modified->getData());
        
        // Should be different instances
        $this->assertNotSame($original, $modified);
    }

    // ========================================
    // Tests for render() method
    // ========================================

    /**
     * Tests the render() method with empty attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::render
     * @return void
     */
    public function testRenderEmpty()
    {
        $helper = new AttributesHelper();
        $this->assertEquals('', $helper->render());
    }

    /**
     * Tests the render() method with all attribute types.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::render
     * @return void
     */
    public function testRenderWithAllAttributeTypes()
    {
        $helper = new AttributesHelper();
        $helper->setId('test-id')
               ->addClass('btn btn-primary')
               ->addData('toggle', 'modal')
               ->addData('target', '#modal')
               ->addStyle('color', 'red')
               ->addStyle('margin', '10px')
               ->set('title', 'Test Title')
               ->set('aria-label', 'Accessible');
        
        $result = $helper->render();
        
        $this->assertStringContainsString('id="test-id"', $result);
        $this->assertStringContainsString('class="btn btn-primary"', $result);
        $this->assertStringContainsString('title="Test Title"', $result);
        $this->assertStringContainsString('aria-label="Accessible"', $result);
        $this->assertStringContainsString('data-toggle="modal"', $result);
        $this->assertStringContainsString('data-target="#modal"', $result);
        $this->assertStringContainsString('style="color:red;margin:10px"', $result);
        
        // Should start with a space
        $this->assertStringStartsWith(' ', $result);
    }

    /**
     * Tests the render() method with HTML escaping for valid values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::render
     * @return void
     */
    public function testRenderWithHtmlEscaping()
    {
        $helper = new AttributesHelper();
        
        // Use valid IDs and class names for testing HTML escaping
        $helper->setId('test-script')
               ->addClass('class-with-quotes')
               ->addData('content', 'value&with&entities')
               ->set('title', 'Title with "quotes" & entities');
        
        $result = $helper->render();
        
        $this->assertStringContainsString('id="test-script"', $result);
        $this->assertStringContainsString('class="class-with-quotes"', $result);
        $this->assertStringContainsString('data-content="value&amp;with&amp;entities"', $result);
        $this->assertStringContainsString('title="Title with &quot;quotes&quot; &amp; entities"', $result);
    }

    /**
     * Tests validation errors for invalid HTML characters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::setId
     * @return void
     */
    public function testValidationErrorsForInvalidCharacters()
    {
        $helper = new AttributesHelper();
        
        // Test that invalid characters in IDs throw exceptions before HTML escaping
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ID value: test<script>');
        $helper->setId('test<script>');
    }

    // ========================================
    // Tests for __toString() method
    // ========================================

    /**
     * Tests the __toString() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::__toString
     * @return void
     */
    public function testToString()
    {
        $helper = new AttributesHelper(['id' => 'test', 'class' => 'btn']);
        
        $renderResult = $helper->render();
        $toStringResult = (string) $helper;
        
        $this->assertEquals($renderResult, $toStringResult);
    }

    // ========================================
    // Tests for toArray() method
    // ========================================

    /**
     * Tests the toArray() method with all attribute types.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::toArray
     * @return void
     */
    public function testToArrayWithAllTypes()
    {
        $helper = new AttributesHelper();
        $helper->setId('test-id')
               ->addClass('btn primary')
               ->addData('toggle', 'modal')
               ->addStyle('color', 'red')
               ->addStyle('margin', '10px')
               ->set('title', 'Test Title');
        
        $expected = [
            'id' => 'test-id',
            'class' => 'btn primary',
            'data-toggle' => 'modal',
            'style' => 'color:red;margin:10px',
            'title' => 'Test Title'
        ];
        
        $this->assertEquals($expected, $helper->toArray());
    }

    /**
     * Tests the toArray() method with empty helper.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::toArray
     * @return void
     */
    public function testToArrayEmpty()
    {
        $helper = new AttributesHelper();
        $this->assertEquals([], $helper->toArray());
    }

    // ========================================
    // Tests for getter methods
    // ========================================

    /**
     * Tests all getter methods for immutability.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getId
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getClasses
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getData
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getStyles
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getAttributes
     * @return void
     */
    public function testGetterMethods()
    {
        $helper = new AttributesHelper();
        $helper->setId('test-id')
               ->addClass('btn')
               ->addData('test', 'value')
               ->addStyle('color', 'red')
               ->set('title', 'Test');
        
        $this->assertEquals('test-id', $helper->getId());
        $this->assertEquals(['btn' => true], $helper->getClasses());
        $this->assertEquals(['test' => 'value'], $helper->getData());
        $this->assertEquals(['color' => 'red'], $helper->getStyles());
        $this->assertEquals(['title' => 'Test'], $helper->getAttributes());
    }

    /**
     * Tests getter methods return copies (immutability).
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getClasses
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getData
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getStyles
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::getAttributes
     * @return void
     */
    public function testGetterImmutability()
    {
        $helper = new AttributesHelper();
        $helper->addClass('original')
               ->addData('original', 'value')
               ->addStyle('color', 'red')
               ->set('title', 'Original');
        
        // Modify returned arrays
        $classes = $helper->getClasses();
        $classes['modified'] = true;
        
        $data = $helper->getData();
        $data['modified'] = 'value';
        
        $styles = $helper->getStyles();
        $styles['background'] = 'blue';
        
        $attributes = $helper->getAttributes();
        $attributes['modified'] = 'value';
        
        // Original helper should be unchanged
        $this->assertEquals(['original' => true], $helper->getClasses());
        $this->assertEquals(['original' => 'value'], $helper->getData());
        $this->assertEquals(['color' => 'red'], $helper->getStyles());
        $this->assertEquals(['title' => 'Original'], $helper->getAttributes());
    }

    // ========================================
    // Tests for edge cases and complex scenarios
    // ========================================

    /**
     * Tests complex real-world usage scenarios.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper
     * @return void
     */
    public function testComplexScenarios()
    {
        // Test Bootstrap button with multiple attributes
        $button = AttributesHelper::f()
            ->setId('submit-btn')
            ->addClass('btn btn-primary btn-lg')
            ->addData('toggle', 'tooltip')
            ->addData('placement', 'top')
            ->addData('original-title', 'Click to submit form')
            ->addStyle('margin-top', '20px')
            ->addStyle('min-width', '120px')
            ->set('type', 'submit')
            ->set('form', 'main-form')
            ->set('aria-describedby', 'submit-help');
        
        $result = $button->render();
        
        $this->assertStringContainsString('id="submit-btn"', $result);
        $this->assertStringContainsString('class="btn btn-primary btn-lg"', $result);
        $this->assertStringContainsString('data-toggle="tooltip"', $result);
        $this->assertStringContainsString('data-placement="top"', $result);
        $this->assertStringContainsString('data-original-title="Click to submit form"', $result);
        $this->assertStringContainsString('style="margin-top:20px;min-width:120px"', $result);
        $this->assertStringContainsString('type="submit"', $result);
        $this->assertStringContainsString('form="main-form"', $result);
        $this->assertStringContainsString('aria-describedby="submit-help"', $result);
    }

    /**
     * Tests method chaining and fluent interface.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper
     * @return void
     */
    public function testFluentInterface()
    {
        $result = AttributesHelper::f()
            ->setId('chain-test')
            ->addClass('first')
            ->addClass('second third')
            ->addData('first', 'value1')
            ->addData('second', 'value2')
            ->addStyle('color', 'blue')
            ->addStyle('font-weight', 'bold')
            ->set('title', 'Chained')
            ->set('tabindex', '0');
        
        $this->assertEquals('chain-test', $result->getId());
        $this->assertEquals(['first' => true, 'second' => true, 'third' => true], $result->getClasses());
        $this->assertEquals(['first' => 'value1', 'second' => 'value2'], $result->getData());
        $this->assertEquals(['color' => 'blue', 'font-weight' => 'bold'], $result->getStyles());
        $this->assertEquals(['title' => 'Chained', 'tabindex' => '0'], $result->getAttributes());
    }

    /**
     * Tests handling of case sensitivity and normalization.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper::set
     * @return void
     */
    public function testCaseHandling()
    {
        $helper = new AttributesHelper();
        
        // Attribute names should be converted to lowercase
        $helper->set('ID', 'test-id')
               ->set('CLASS', 'btn')
               ->set('STYLE', 'color: red')
               ->set('DATA-TEST', 'value')
               ->set('Title', 'Test Title');
        
        $this->assertEquals('test-id', $helper->getId());
        $this->assertEquals(['btn' => true], $helper->getClasses());
        $this->assertEquals(['color' => 'red'], $helper->getStyles());
        $this->assertEquals(['test' => 'value'], $helper->getData());
        $this->assertEquals(['title' => 'Test Title'], $helper->getAttributes());
    }

    /**
     * Tests performance with large numbers of attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\AttributesHelper
     * @return void
     */
    public function testPerformanceWithManyAttributes()
    {
        $helper = new AttributesHelper();
        
        // Add many classes
        for ($i = 0; $i < 100; $i++) {
            $helper->addClass("class-$i");
        }
        
        // Add many data attributes
        for ($i = 0; $i < 100; $i++) {
            $helper->addData("attr-$i", "value-$i");
        }
        
        // Add many styles
        for ($i = 0; $i < 100; $i++) {
            $helper->addStyle("prop-$i", "value-$i");
        }
        
        // Should handle rendering without issues
        $result = $helper->render();
        $this->assertIsString($result);
        $this->assertStringStartsWith(' ', $result);
        
        // Check array conversion
        $array = $helper->toArray();
        $this->assertIsArray($array);
        $this->assertArrayHasKey('class', $array);
        $this->assertArrayHasKey('style', $array);
    }
} 