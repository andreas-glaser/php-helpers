<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class TableHelper.
 */
class TableHelper implements RenderableInterface, FactoryInterface
{
    /**
     * @var Row[]
     */
    protected $headRows = [];

    /**
     * @var Row[]
     */
    protected $bodyRows = [];

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $attributes;

    /**
     * @param array                       $headRows
     * @param array                       $bodyRows
     * @param AttributesHelper|array|null $attributesHelper
     *
     * @return \AndreasGlaser\Helpers\Html\Table\TableHelper
     */
    public static function f(array $headRows = null, array $bodyRows = null, $attributesHelper = null)
    {
        return new TableHelper($headRows, $bodyRows, $attributesHelper);
    }

    /**
     * @param array                       $headRows
     * @param array                       $bodyRows
     * @param AttributesHelper|array|null $attributesHelper
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
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return $this
     */
    public function setAttributes(AttributesHelper $attributes):self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\Table\Row $rowHelper
     *
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
     * @return \AndreasGlaser\Helpers\Html\Table\Row[]
     */
    public function getHeadRows()
    {
        return $this->headRows;
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\Table\Row $rowHelper
     *
     * @return $this
     */
    public function addBodyRow(Row $rowHelper):self
    {
        $this->bodyRows[] = $rowHelper;

        return $this;
    }

    /**
     * @return \AndreasGlaser\Helpers\Html\Table\Row[]
     */
    public function getBodyRows()
    {
        return $this->bodyRows;
    }

    /**
     * @return string
     */
    public function render(RendererInterface $renderer = null)
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
