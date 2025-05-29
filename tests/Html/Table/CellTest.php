<?php

namespace Tests\Html\Table;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Html\Table\Cell;
use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException;

/**
 * CellTest provides unit tests for the Cell class.
 *
 * This class tests HTML table cell functionality:
 * - Cell creation and factory methods
 * - Content management (get/set)
 * - Header cell functionality (th vs td)
 * - Colspan and rowspan attributes
 * - Scope attribute (deprecated HTML5 feature)
 * - HTML rendering with proper attributes
 * - Exception handling for invalid inputs
 */
class CellTest extends TestCase
{
    // =====================================
    // Tests for constructor and factory
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::__construct
     */
    public function testConstructorCreatesInstance()
    {
        $cell = new Cell();
        $this->assertInstanceOf(Cell::class, $cell);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::__construct
     */
    public function testConstructorWithContent()
    {
        $content = 'Test Content';
        $cell = new Cell($content);
        
        $this->assertEquals($content, $cell->getContent());
        $this->assertFalse($cell->isHeader());
        $this->assertInstanceOf(AttributesHelper::class, $cell->getAttributes());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::__construct
     */
    public function testConstructorWithAllParameters()
    {
        $content = 'Header Content';
        $attributes = ['class' => 'header-cell', 'id' => 'cell-1'];
        $isHeader = true;
        
        $cell = new Cell($content, $attributes, $isHeader);
        
        $this->assertEquals($content, $cell->getContent());
        $this->assertTrue($cell->isHeader());
        
        // Check ID (stored in regular attributes)
        $this->assertEquals('cell-1', $cell->getAttributes()->getId());
        
        // Check class (stored specially in classes array)
        $classes = $cell->getAttributes()->getClasses();
        $this->assertArrayHasKey('header-cell', $classes);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::f
     */
    public function testFactoryMethodExists()
    {
        $this->assertTrue(method_exists(Cell::class, 'f'));
    }

    // =====================================
    // Tests for content management
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::getContent
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setContent
     */
    public function testContentGetterAndSetter()
    {
        $cell = new Cell();
        $content = 'New Content';
        
        $this->assertNull($cell->getContent());
        
        $result = $cell->setContent($content);
        
        $this->assertSame($cell, $result); // Test fluent interface
        $this->assertEquals($content, $cell->getContent());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setContent
     */
    public function testSetContentWithEmptyString()
    {
        $cell = new Cell('Initial');
        $cell->setContent('');
        
        $this->assertEquals('', $cell->getContent());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setContent
     */
    public function testSetContentWithHtml()
    {
        $cell = new Cell();
        $htmlContent = '<strong>Bold Text</strong>';
        $cell->setContent($htmlContent);
        
        $this->assertEquals($htmlContent, $cell->getContent());
    }

    // =====================================
    // Tests for header functionality
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::isHeader
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setIsHeader
     */
    public function testHeaderFunctionality()
    {
        $cell = new Cell();
        
        $this->assertFalse($cell->isHeader()); // Default is false
        
        $result = $cell->setIsHeader(true);
        
        $this->assertSame($cell, $result); // Test fluent interface
        $this->assertTrue($cell->isHeader());
        
        $cell->setIsHeader(false);
        $this->assertFalse($cell->isHeader());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::__construct
     */
    public function testConstructorWithHeaderFlag()
    {
        $headerCell = new Cell('Header', null, true);
        $regularCell = new Cell('Data', null, false);
        
        $this->assertTrue($headerCell->isHeader());
        $this->assertFalse($regularCell->isHeader());
    }

    // =====================================
    // Tests for colspan functionality
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setColSpan
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::getColSpan
     */
    public function testColSpanGetterAndSetter()
    {
        $cell = new Cell();
        
        $this->assertNull($cell->getColSpan()); // Default is null
        
        $result = $cell->setColSpan(3);
        
        $this->assertSame($cell, $result); // Test fluent interface
        $this->assertEquals(3, $cell->getColSpan());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setColSpan
     */
    public function testSetColSpanWithValidValues()
    {
        $cell = new Cell();
        
        $cell->setColSpan(1);
        $this->assertEquals(1, $cell->getColSpan());
        
        $cell->setColSpan(10);
        $this->assertEquals(10, $cell->getColSpan());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setColSpan
     */
    public function testSetColSpanWithInvalidType()
    {
        $cell = new Cell();
        
        $this->expectException(UnexpectedTypeException::class);
        $cell->setColSpan('invalid');
    }

    // =====================================
    // Tests for rowspan functionality
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setRowSpan
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::getRowSpan
     */
    public function testRowSpanGetterAndSetter()
    {
        $cell = new Cell();
        
        $this->assertNull($cell->getRowSpan()); // Default is null
        
        $result = $cell->setRowSpan(2);
        
        $this->assertSame($cell, $result); // Test fluent interface
        $this->assertEquals(2, $cell->getRowSpan());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setRowSpan
     */
    public function testSetRowSpanWithValidValues()
    {
        $cell = new Cell();
        
        $cell->setRowSpan(1);
        $this->assertEquals(1, $cell->getRowSpan());
        
        $cell->setRowSpan(5);
        $this->assertEquals(5, $cell->getRowSpan());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setRowSpan
     */
    public function testSetRowSpanWithInvalidType()
    {
        $cell = new Cell();
        
        $this->expectException(UnexpectedTypeException::class);
        $cell->setRowSpan('invalid');
    }

    // =====================================
    // Tests for scope functionality (deprecated)
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setScope
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::getScope
     */
    public function testScopeGetterAndSetter()
    {
        $cell = new Cell();
        
        $this->assertNull($cell->getScope()); // Default is null
        
        $result = $cell->setScope('col');
        
        $this->assertSame($cell, $result); // Test fluent interface
        $this->assertEquals('col', $cell->getScope());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setScope
     */
    public function testSetScopeWithValidValues()
    {
        $cell = new Cell();
        $validScopes = ['col', 'row', 'colgroup', 'rowgroup'];
        
        foreach ($validScopes as $scope) {
            $cell->setScope($scope);
            $this->assertEquals($scope, $cell->getScope());
        }
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::setScope
     */
    public function testSetScopeWithInvalidValue()
    {
        $cell = new Cell();
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('"invalid" is not a valid <td> scope');
        $cell->setScope('invalid');
    }

    // =====================================
    // Tests for attributes
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::getAttributes
     */
    public function testGetAttributes()
    {
        $cell = new Cell();
        $attributes = $cell->getAttributes();
        
        $this->assertInstanceOf(AttributesHelper::class, $attributes);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::__construct
     */
    public function testConstructorWithAttributesHelper()
    {
        $attrs = new AttributesHelper(['class' => 'test-cell']);
        $cell = new Cell('Content', $attrs);
        
        $this->assertSame($attrs, $cell->getAttributes());
    }

    // =====================================
    // Tests for rendering
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderRegularCell()
    {
        $cell = new Cell('Test Content', null, false);
        $html = $cell->render();
        
        $this->assertEquals('<td>Test Content</td>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderHeaderCell()
    {
        $cell = new Cell('Header Content', null, true);
        $html = $cell->render();
        
        $this->assertEquals('<th>Header Content</th>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderWithAttributes()
    {
        $attributes = ['class' => 'highlight', 'id' => 'cell-1'];
        $cell = new Cell('Content', $attributes);
        $html = $cell->render();
        
        $this->assertStringContainsString('<td', $html);
        $this->assertStringContainsString('class="highlight"', $html);
        $this->assertStringContainsString('id="cell-1"', $html);
        $this->assertStringContainsString('>Content</td>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderWithColspanAndRowspan()
    {
        $cell = new Cell('Spanning Cell');
        $cell->setColSpan(2)->setRowSpan(3);
        $html = $cell->render();
        
        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('rowspan="3"', $html);
        $this->assertStringContainsString('>Spanning Cell</td>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderEmptyCell()
    {
        $cell = new Cell();
        $html = $cell->render();
        
        $this->assertEquals('<td></td>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderWithNullContent()
    {
        $cell = new Cell(null);
        $html = $cell->render();
        
        $this->assertEquals('<td></td>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderWithScope()
    {
        $cell = new Cell('Header', null, true);
        $cell->setScope('col');
        $html = $cell->render();
        
        $this->assertStringContainsString('<th', $html);
        $this->assertStringContainsString('scope="col"', $html);
        $this->assertStringContainsString('>Header</th>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Cell::render
     */
    public function testRenderWithCustomRenderer()
    {
        $cell = new Cell('Test');
        
        // Test with null renderer (default behavior)
        $html = $cell->render(null);
        $this->assertEquals('<td>Test</td>', $html);
        
        // Without renderer parameter
        $html2 = $cell->render();
        $this->assertEquals($html, $html2);
    }

    // =====================================
    // Tests for interface implementations
    // =====================================

    /**
     * @test
     */
    public function testImplementsRenderableInterface()
    {
        $cell = new Cell();
        $this->assertInstanceOf(\AndreasGlaser\Helpers\Interfaces\RenderableInterface::class, $cell);
    }

    // =====================================
    // Integration tests
    // =====================================

    /**
     * @test
     */
    public function testComplexCellCreationAndRendering()
    {
        // Create a complex header cell with all features
        $cell = new Cell('Complex Header', ['class' => 'complex'], true);
        $cell->setColSpan(2)
             ->setRowSpan(1)
             ->setScope('colgroup');
        
        $html = $cell->render();
        
        // Verify all features are present
        $this->assertStringContainsString('<th', $html);
        $this->assertStringContainsString('class="complex"', $html);
        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('rowspan="1"', $html);
        $this->assertStringContainsString('scope="colgroup"', $html);
        $this->assertStringContainsString('>Complex Header</th>', $html);
    }

    /**
     * @test
     */
    public function testFluentInterface()
    {
        $cell = new Cell();
        
        $result = $cell->setContent('Test')
                       ->setIsHeader(true)
                       ->setColSpan(2)
                       ->setRowSpan(1)
                       ->setScope('col');
        
        $this->assertSame($cell, $result);
        $this->assertEquals('Test', $cell->getContent());
        $this->assertTrue($cell->isHeader());
        $this->assertEquals(2, $cell->getColSpan());
        $this->assertEquals(1, $cell->getRowSpan());
        $this->assertEquals('col', $cell->getScope());
    }
} 