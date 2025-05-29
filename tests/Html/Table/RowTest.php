<?php

namespace Tests\Html\Table;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Html\Table\Row;
use AndreasGlaser\Helpers\Html\Table\Cell;
use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * RowTest provides unit tests for the Row class.
 *
 * This class tests HTML table row functionality:
 * - Row creation and factory methods
 * - Cell management (add/get cells)
 * - Attribute management
 * - HTML rendering with proper structure
 * - Integration with Cell objects
 * - Interface implementations
 */
class RowTest extends TestCase
{
    // =====================================
    // Tests for constructor and factory
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::__construct
     */
    public function testConstructorCreatesInstance()
    {
        $row = new Row();
        $this->assertInstanceOf(Row::class, $row);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::__construct
     */
    public function testConstructorWithoutParameters()
    {
        $row = new Row();
        
        $this->assertEmpty($row->getCells());
        $this->assertInstanceOf(AttributesHelper::class, $row->getAttributes());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::__construct
     */
    public function testConstructorWithCells()
    {
        $cell1 = new Cell('Cell 1');
        $cell2 = new Cell('Cell 2');
        $cells = [$cell1, $cell2];
        
        $row = new Row($cells);
        
        $this->assertCount(2, $row->getCells());
        $this->assertSame($cell1, $row->getCells()[0]);
        $this->assertSame($cell2, $row->getCells()[1]);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::__construct
     */
    public function testConstructorWithAttributes()
    {
        $attributes = ['class' => 'table-row', 'id' => 'row-1'];
        $row = new Row(null, $attributes);
        
        $this->assertEquals('row-1', $row->getAttributes()->getId());
        $classes = $row->getAttributes()->getClasses();
        $this->assertArrayHasKey('table-row', $classes);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::__construct
     */
    public function testConstructorWithCellsAndAttributes()
    {
        $cell = new Cell('Test Cell');
        $attributes = ['class' => 'styled-row'];
        
        $row = new Row([$cell], $attributes);
        
        $this->assertCount(1, $row->getCells());
        $this->assertSame($cell, $row->getCells()[0]);
        
        $classes = $row->getAttributes()->getClasses();
        $this->assertArrayHasKey('styled-row', $classes);
    }

    // =====================================
    // Tests for cell management
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::addCell
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::getCells
     */
    public function testAddCellAndGetCells()
    {
        $row = new Row();
        $cell = new Cell('Test Content');
        
        $this->assertEmpty($row->getCells());
        
        $result = $row->addCell($cell);
        
        $this->assertSame($row, $result); // Test fluent interface
        $this->assertCount(1, $row->getCells());
        $this->assertSame($cell, $row->getCells()[0]);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::addCell
     */
    public function testAddMultipleCells()
    {
        $row = new Row();
        $cell1 = new Cell('Cell 1');
        $cell2 = new Cell('Cell 2');
        $cell3 = new Cell('Cell 3');
        
        $row->addCell($cell1)
            ->addCell($cell2)
            ->addCell($cell3);
        
        $cells = $row->getCells();
        $this->assertCount(3, $cells);
        $this->assertSame($cell1, $cells[0]);
        $this->assertSame($cell2, $cells[1]);
        $this->assertSame($cell3, $cells[2]);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::addCell
     */
    public function testAddCellsWithDifferentTypes()
    {
        $row = new Row();
        $headerCell = new Cell('Header', null, true);
        $regularCell = new Cell('Data', null, false);
        
        $row->addCell($headerCell)->addCell($regularCell);
        
        $cells = $row->getCells();
        $this->assertCount(2, $cells);
        $this->assertTrue($cells[0]->isHeader());
        $this->assertFalse($cells[1]->isHeader());
    }

    // =====================================
    // Tests for attribute management
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::getAttributes
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::setAttributes
     */
    public function testAttributeGetterAndSetter()
    {
        $row = new Row();
        $attributes = new AttributesHelper(['class' => 'test-row', 'data-id' => '123']);
        
        $result = $row->setAttributes($attributes);
        
        $this->assertSame($row, $result); // Test fluent interface
        $this->assertSame($attributes, $row->getAttributes());
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::getAttributes
     */
    public function testGetAttributesReturnsAttributesHelper()
    {
        $row = new Row();
        $attributes = $row->getAttributes();
        
        $this->assertInstanceOf(AttributesHelper::class, $attributes);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::__construct
     */
    public function testConstructorWithAttributesHelper()
    {
        $attrs = new AttributesHelper(['id' => 'test-row']);
        $row = new Row(null, $attrs);
        
        $this->assertSame($attrs, $row->getAttributes());
    }

    // =====================================
    // Tests for rendering
    // =====================================

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderEmptyRow()
    {
        $row = new Row();
        $html = $row->render();
        
        $this->assertEquals('<tr></tr>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderRowWithSingleCell()
    {
        $row = new Row();
        $cell = new Cell('Test Content');
        $row->addCell($cell);
        
        $html = $row->render();
        
        $this->assertEquals('<tr><td>Test Content</td></tr>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderRowWithMultipleCells()
    {
        $row = new Row();
        $cell1 = new Cell('Cell 1');
        $cell2 = new Cell('Cell 2');
        $cell3 = new Cell('Cell 3');
        
        $row->addCell($cell1)->addCell($cell2)->addCell($cell3);
        
        $html = $row->render();
        
        $expected = '<tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td></tr>';
        $this->assertEquals($expected, $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderRowWithAttributes()
    {
        $row = new Row(null, ['class' => 'styled', 'id' => 'row-1']);
        $cell = new Cell('Content');
        $row->addCell($cell);
        
        $html = $row->render();
        
        $this->assertStringContainsString('<tr', $html);
        $this->assertStringContainsString('class="styled"', $html);
        $this->assertStringContainsString('id="row-1"', $html);
        $this->assertStringContainsString('><td>Content</td></tr>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderRowWithHeaderAndDataCells()
    {
        $row = new Row();
        $headerCell = new Cell('Header', null, true);
        $dataCell = new Cell('Data', null, false);
        
        $row->addCell($headerCell)->addCell($dataCell);
        
        $html = $row->render();
        
        $expected = '<tr><th>Header</th><td>Data</td></tr>';
        $this->assertEquals($expected, $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderRowWithCellAttributes()
    {
        $row = new Row();
        $cell = new Cell('Content', ['class' => 'cell-style']);
        $row->addCell($cell);
        
        $html = $row->render();
        
        $this->assertStringContainsString('<tr><td class="cell-style">Content</td></tr>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderRowWithColspanAndRowspan()
    {
        $row = new Row();
        $cell = new Cell('Spanning Cell');
        $cell->setColSpan(2)->setRowSpan(1);
        $row->addCell($cell);
        
        $html = $row->render();
        
        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('rowspan="1"', $html);
        $this->assertStringContainsString('>Spanning Cell</td>', $html);
    }

    /**
     * @test
     * @covers \AndreasGlaser\Helpers\Html\Table\Row::render
     */
    public function testRenderWithCustomRenderer()
    {
        $row = new Row();
        $cell = new Cell('Test');
        $row->addCell($cell);
        
        // Test with null renderer (default behavior)
        $html = $row->render(null);
        $this->assertEquals('<tr><td>Test</td></tr>', $html);
        
        // Without renderer parameter
        $html2 = $row->render();
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
        $row = new Row();
        $this->assertInstanceOf(\AndreasGlaser\Helpers\Interfaces\RenderableInterface::class, $row);
    }

    // =====================================
    // Integration tests
    // =====================================

    /**
     * @test
     */
    public function testComplexRowCreationAndRendering()
    {
        // Create a complex row with various cell types and attributes
        $row = new Row();
        $row->getAttributes()->addClass('data-row');
        
        // Header cell with scope
        $headerCell = new Cell('Product', ['class' => 'header'], true);
        $headerCell->setScope('col');
        
        // Regular cell with attributes
        $nameCell = new Cell('Laptop', ['class' => 'product-name']);
        
        // Cell with colspan
        $priceCell = new Cell('$999.99', ['class' => 'price']);
        $priceCell->setColSpan(2);
        
        $row->addCell($headerCell)
            ->addCell($nameCell)
            ->addCell($priceCell);
        
        $html = $row->render();
        
        // Verify row structure
        $this->assertStringContainsString('<tr class="data-row">', $html);
        $this->assertStringContainsString('<th class="header" scope="col">Product</th>', $html);
        $this->assertStringContainsString('<td class="product-name">Laptop</td>', $html);
        $this->assertStringContainsString('<td class="price" colspan="2">$999.99</td>', $html);
        $this->assertStringContainsString('</tr>', $html);
    }

    /**
     * @test
     */
    public function testFluentInterface()
    {
        $row = new Row();
        $cell1 = new Cell('Cell 1');
        $cell2 = new Cell('Cell 2');
        $attributes = new AttributesHelper(['class' => 'test']);
        
        $result = $row->addCell($cell1)
                      ->addCell($cell2)
                      ->setAttributes($attributes);
        
        $this->assertSame($row, $result);
        $this->assertCount(2, $row->getCells());
        $this->assertSame($attributes, $row->getAttributes());
    }

    /**
     * @test
     */
    public function testConstructorWithEmptyArrays()
    {
        $row = new Row([], []);
        
        $this->assertEmpty($row->getCells());
        $this->assertInstanceOf(AttributesHelper::class, $row->getAttributes());
    }

    /**
     * @test
     */
    public function testRenderOrderConsistency()
    {
        $row = new Row();
        
        // Add cells in specific order
        $cell1 = new Cell('First');
        $cell2 = new Cell('Second');
        $cell3 = new Cell('Third');
        
        $row->addCell($cell1)
            ->addCell($cell2)
            ->addCell($cell3);
        
        $html = $row->render();
        
        // Verify order is maintained
        $firstPos = strpos($html, 'First');
        $secondPos = strpos($html, 'Second');
        $thirdPos = strpos($html, 'Third');
        
        $this->assertLessThan($secondPos, $firstPos);
        $this->assertLessThan($thirdPos, $secondPos);
    }

    /**
     * @test
     */
    public function testRenderWithMixedCellContent()
    {
        $row = new Row();
        
        // Add cells with different content types
        $emptyCell = new Cell('');
        $nullCell = new Cell(null);
        $htmlCell = new Cell('<strong>Bold</strong>');
        $numberCell = new Cell('123');
        
        $row->addCell($emptyCell)
            ->addCell($nullCell)
            ->addCell($htmlCell)
            ->addCell($numberCell);
        
        $html = $row->render();
        
        $expected = '<tr><td></td><td></td><td><strong>Bold</strong></td><td>123</td></tr>';
        $this->assertEquals($expected, $html);
    }

    /**
     * @test
     */
    public function testLargeNumberOfCells()
    {
        $row = new Row();
        $numberOfCells = 10;
        
        // Add many cells
        for ($i = 1; $i <= $numberOfCells; $i++) {
            $cell = new Cell("Cell $i");
            $row->addCell($cell);
        }
        
        $cells = $row->getCells();
        $this->assertCount($numberOfCells, $cells);
        
        $html = $row->render();
        
        // Verify all cells are rendered
        for ($i = 1; $i <= $numberOfCells; $i++) {
            $this->assertStringContainsString("<td>Cell $i</td>", $html);
        }
    }
} 