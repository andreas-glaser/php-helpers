<?php

namespace Tests\Html\Table;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Html\Table\TableHelper;
use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * TableHelperTest provides unit tests for the TableHelper class.
 *
 * This class tests HTML table generation methods:
 * - Table creation and basic functionality
 * - HTML attribute handling  
 * - Table rendering with proper HTML structure
 * - Edge cases and empty tables
 */
class TableHelperTest extends TestCase
{
    // ========================================
    // Tests for constructor
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::__construct
     */
    public function testConstructorCreatesInstance()
    {
        $table = new TableHelper();
        $this->assertInstanceOf(TableHelper::class, $table);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::__construct
     */
    public function testConstructorCreatesEmptyTable()
    {
        $table = new TableHelper();
        
        $this->assertEmpty($table->getHeadRows());
        $this->assertEmpty($table->getBodyRows());
        $this->assertInstanceOf(AttributesHelper::class, $table->getAttributes());
    }

    // ========================================
    // Tests for attribute handling
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::getAttributes
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::setAttributes
     */
    public function testAttributeGetterAndSetter()
    {
        $table = new TableHelper();
        $attributes = new AttributesHelper(['id' => 'my-table', 'class' => 'styled']);
        
        $result = $table->setAttributes($attributes);
        
        $this->assertSame($table, $result); // Test fluent interface
        $this->assertSame($attributes, $table->getAttributes());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::__construct
     */
    public function testConstructorWithArrayAttributes()
    {
        $attributes = ['border' => '1', 'cellpadding' => '5'];
        $table = new TableHelper(null, null, $attributes);
        
        $attributesArray = $table->getAttributes()->getAttributes();
        $this->assertEquals('1', $attributesArray['border']);
        $this->assertEquals('5', $attributesArray['cellpadding']);
    }

    // ========================================
    // Tests for basic getters
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::getHeadRows
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::getBodyRows
     */
    public function testGettersReturnEmptyArraysByDefault()
    {
        $table = new TableHelper();
        
        $this->assertIsArray($table->getHeadRows());
        $this->assertIsArray($table->getBodyRows());
        $this->assertEmpty($table->getHeadRows());
        $this->assertEmpty($table->getBodyRows());
    }

    // ========================================
    // Tests for rendering
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::render
     */
    public function testRenderEmptyTable()
    {
        $table = new TableHelper();
        $html = $table->render();
        
        $this->assertEquals('<table></table>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::render
     */
    public function testRenderTableWithAttributes()
    {
        $table = new TableHelper(null, null, ['class' => 'styled', 'id' => 'data-table']);
        $html = $table->render();
        
        // Check for both possible attribute orders since order may vary
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('class="styled"', $html);
        $this->assertStringContainsString('id="data-table"', $html);
        $this->assertStringContainsString('</table>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::__construct
     */
    public function testConstructorWithNullParameters()
    {
        $table = new TableHelper(null, null, null);
        
        $this->assertEmpty($table->getHeadRows());
        $this->assertEmpty($table->getBodyRows());
        $this->assertInstanceOf(AttributesHelper::class, $table->getAttributes());
    }

    // ========================================
    // Tests for factory method (without interface conflict)
    // ========================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::f
     */
    public function testFactoryMethodExists()
    {
        $this->assertTrue(method_exists(TableHelper::class, 'f'));
    }

    // ========================================
    // Tests for implementation verification
    // ========================================

    /**
     * @test
     */
    public function testImplementsRenderableInterface()
    {
        $table = new TableHelper();
        $this->assertInstanceOf(\AndreasGlaser\Helpers\Interfaces\RenderableInterface::class, $table);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::render
     */
    public function testRenderReturnsString()
    {
        $table = new TableHelper();
        $html = $table->render();
        
        $this->assertIsString($html);
        $this->assertStringStartsWith('<table', $html);
        $this->assertStringEndsWith('</table>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::render
     */
    public function testRenderWithDifferentAttributes()
    {
        $table1 = new TableHelper(null, null, ['border' => '1']);
        $table2 = new TableHelper(null, null, ['cellspacing' => '0']);
        
        $html1 = $table1->render();
        $html2 = $table2->render();
        
        $this->assertStringContainsString('border="1"', $html1);
        $this->assertStringContainsString('cellspacing="0"', $html2);
        $this->assertStringNotContainsString('cellspacing', $html1);
        $this->assertStringNotContainsString('border', $html2);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\TableHelper::render
     */
    public function testRenderWithCustomRenderer()
    {
        $table = new TableHelper();
        
        // Test with null renderer (default behavior)
        $html = $table->render(null);
        $this->assertEquals('<table></table>', $html);
        
        // Without renderer parameter
        $html2 = $table->render();
        $this->assertEquals($html, $html2);
    }
} 