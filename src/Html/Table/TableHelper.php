<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class TableHelper
 * 
 * A helper class for generating HTML tables with support for header and body rows.
 * Implements RenderableInterface for HTML rendering.
 */
class TableHelper implements RenderableInterface
{
    /**
     * @var Row[] Array of header rows in the table
     */
    protected $headRows = [];

    /**
     * @var Row[] Array of body rows in the table
     */
    protected $bodyRows = [];

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper HTML attributes for the table element
     */
    protected $attributes;

    /**
     * Factory method to create a new TableHelper instance
     *
     * @param array                       $headRows        Array of header rows
     * @param array                       $bodyRows        Array of body rows
     * @param AttributesHelper|array|null $attributesHelper HTML attributes for the table
     *
     * @return \AndreasGlaser\Helpers\Html\Table\TableHelper
     */
    public static function f(array $headRows = null, array $bodyRows = null, $attributesHelper = null): self
    {
        return new TableHelper($headRows, $bodyRows, $attributesHelper);
    }

    /**
     * Constructor for TableHelper
     *
     * @param array                       $headRows        Array of header rows
     * @param array                       $bodyRows        Array of body rows
     * @param AttributesHelper|array|null $attributesHelper HTML attributes for the table
     */
    public function __construct(array $headRows = null, array $bodyRows = null, $attributesHelper = null)
    {
        if ($headRows) {
            foreach ($headRows as $headRow) {
                $this->addHeadRow($headRow);
            }
        }

        if ($bodyRows) {
            foreach ($bodyRows as $bodyRow) {
                $this->addBodyRow($bodyRow);
            }
        }

        $this->attributes = AttributesHelper::f($attributesHelper);
    }

    /**
     * Get the HTML attributes for the table
     *
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    public function getAttributes(): AttributesHelper
    {
        return $this->attributes;
    }

    /**
     * Set the HTML attributes for the table
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
     * Add a header row to the table
     *
     * @param \AndreasGlaser\Helpers\Html\Table\Row $rowHelper      The row to add
     * @param bool                                  $setCellAsHeaders Whether to set all cells in the row as header cells
     * @return $this
     */
    public function addHeadRow(Row $rowHelper, bool $setCellAsHeaders = true): self
    {
        if (true === $setCellAsHeaders) {
            foreach ($rowHelper->getCells() as $cell) {
                $cell->setIsHeader(true);
            }
        }

        $this->headRows[] = $rowHelper;

        return $this;
    }

    /**
     * Get all header rows in the table
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Row[]
     */
    public function getHeadRows(): array
    {
        return $this->headRows;
    }

    /**
     * Add a body row to the table
     *
     * @param \AndreasGlaser\Helpers\Html\Table\Row $rowHelper The row to add
     * @return $this
     */
    public function addBodyRow(Row $rowHelper):self
    {
        $this->bodyRows[] = $rowHelper;

        return $this;
    }

    /**
     * Get all body rows in the table
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Row[]
     */
    public function getBodyRows(): array
    {
        return $this->bodyRows;
    }

    /**
     * Render the table as HTML
     *
     * @param RendererInterface|null $renderer Optional custom renderer
     * @return string The rendered HTML table
     */
    public function render(RendererInterface $renderer = null): string
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $html = '<table' . $this->getAttributes()->render() . '>';

        $headRows = $this->getHeadRows();

        if (!empty($headRows)) {
            $html .= '<thead>';

            foreach ($headRows as $row) {
                $html .= $row->render();
            }

            $html .= '</thead>';
        }

        $bodyRows = $this->getBodyRows();

        if (!empty($bodyRows)) {
            $html .= '<tbody>';

            foreach ($bodyRows as $row) {
                $html .= $row->render();
            }

            $html .= '</tbody>';
        }

        $html .= '</table>';

        return $html;
    }
}
