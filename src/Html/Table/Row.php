<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class Row
 * 
 * Represents a row (tr) in an HTML table.
 * Implements RenderableInterface for HTML rendering and FactoryInterface for static factory methods.
 */
class Row implements RenderableInterface, FactoryInterface
{
    /**
     * @var Cell[] Array of cells in this row
     */
    protected $cells = [];

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper HTML attributes for the row
     */
    protected $attributes;

    /**
     * Factory method to create a new Row instance
     *
     * @param array                       $cells           Array of cells to add to the row
     * @param AttributesHelper|array|null $attributesHelper HTML attributes for the row
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Row
     */
    public static function f(array $cells = null, $attributesHelper = null)
    {
        return new Row($cells, $attributesHelper);
    }

    /**
     * Constructor for Row
     *
     * @param array                       $cells           Array of cells to add to the row
     * @param AttributesHelper|array|null $attributesHelper HTML attributes for the row
     */
    public function __construct(array $cells = null, $attributesHelper = null)
    {
        if ($cells) {
            foreach ($cells as $cell) {
                $this->addCell($cell);
            }
        }

        $this->attributes = AttributesHelper::f($attributesHelper);
    }

    /**
     * Add a cell to the row
     *
     * @param \AndreasGlaser\Helpers\Html\Table\Cell $cellHelper The cell to add
     * @return $this
     */
    public function addCell(Cell $cellHelper):self
    {
        $this->cells[] = $cellHelper;

        return $this;
    }

    /**
     * Get all cells in the row
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Cell[]
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * Get the HTML attributes of the row
     *
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the HTML attributes of the row
     *
     * @param AttributesHelper $attributes The attributes to set
     * @return $this
     */
    public function setAttributes(AttributesHelper $attributes):self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Render the row as HTML
     *
     * @param RendererInterface|null $renderer Optional custom renderer
     * @return string The rendered HTML row
     */
    public function render(RendererInterface $renderer = null)
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $html = '<tr' . $this->attributes->render() . '>';
        foreach ($this->getCells() as $cell) {
            $html .= $cell->render();
        }
        $html .= '</tr>';

        return $html;
    }
}
