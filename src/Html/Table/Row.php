<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class Row
 *
 * @package AndreasGlaser\Helpers\Html\Table
 */
class Row implements RenderableInterface, FactoryInterface
{
    /**
     * @var Cell[]
     */
    protected $cells = [];

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $attributes;

    /**
     * @param array|null                  $cells
     * @param AttributesHelper|array|null $attributesHelper
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Row
     */
    public static function f(array $cells = null, $attributesHelper = null)
    {
        return new Row($cells, $attributesHelper);
    }

    /**
     * @param array|null $cells
     * @param null       $attributesHelper
     */
    public function __construct(array $cells = null, $attributesHelper = null)
    {
        if ($cells) {
            foreach ($cells AS $cell) {
                $this->addCell($cell);
            }
        }

        $this->attributes = AttributesHelper::f($attributesHelper);
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\Table\Cell $cellHelper
     *
     * @return $this
     */
    public function addCell(Cell $cellHelper)
    {
        $this->cells[] = $cellHelper;

        return $this;
    }

    /**
     * @return \AndreasGlaser\Helpers\Html\Table\Cell[]
     */
    public function getCells()
    {
        return $this->cells;
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
     * @param \AndreasGlaser\Helpers\Interfaces\RendererInterface|null $renderer
     *
     * @return string
     */
    public function render(RendererInterface $renderer = null)
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $html = '<tr' . $this->attributes->render() . '>';
        foreach ($this->getCells() AS $cell) {
            $html .= $cell->render();
        }
        $html .= '</tr>';

        return $html;
    }
}