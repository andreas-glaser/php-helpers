<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class Row.
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
     * @param AttributesHelper|array|null $attributesHelper
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Row
     */
    public static function f(array $cells = null, $attributesHelper = null)
    {
        return new Row($cells, $attributesHelper);
    }

    /**
     * @param null $attributesHelper
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
     * @param \AndreasGlaser\Helpers\Html\Table\Cell $cellHelper
     *
     * @return $this
     */
    public function addCell(Cell $cellHelper):self
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
     * @return $this
     */
    public function setAttributes(AttributesHelper $attributes):self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return string
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
