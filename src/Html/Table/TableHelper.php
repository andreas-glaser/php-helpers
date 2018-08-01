<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class TableHelper
 *
 * @package AndreasGlaser\Helpers\Html\Table
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
            foreach ($headRows AS $headRow) {
                $this->addHeadRow($headRow);
            }
        }

        if ($bodyRows) {
            foreach ($bodyRows AS $bodyRow) {
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
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributes
     *
     * @return $this
     */
    public function setAttributes(AttributesHelper $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\Table\Row $rowHelper
     *
     * @return $this
     */
    public function addHeadRow(Row $rowHelper)
    {
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
    public function addBodyRow(Row $rowHelper)
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
     * @param \AndreasGlaser\Helpers\Interfaces\RendererInterface|null $renderer
     *
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

            foreach ($headRows AS $row) {
                $html .= $row->render();
            }

            $html .= '</thead>';
        }

        $bodyRows = $this->getBodyRows();

        if (!empty($bodyRows)) {
            $html .= '<tbody>';

            foreach ($bodyRows AS $row) {
                $html .= $row->render();
            }

            $html .= '</tbody>';
        }

        $html .= '</table>';

        return $html;
    }
}