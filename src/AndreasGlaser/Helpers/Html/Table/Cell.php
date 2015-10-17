<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class Cell
 *
 * @package AndreasGlaser\Helpers\Html\Table
 * @author  Andreas Glaser
 */
class Cell implements RenderableInterface, FactoryInterface
{
    /**
     * @var string|null
     */
    protected $content = null;

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $attributes;

    /**
     * @param null                        $content
     * @param AttributesHelper|array|null $attributesHelper
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Cell
     * @author Andreas Glaser
     */
    public static function f($content = null, $attributesHelper = null)
    {
        return new Cell($content, $attributesHelper);
    }

    /**
     * @param null                         $content
     * @param  AttributesHelper|array|null $attributesHelper
     */
    public function __construct($content = null, $attributesHelper = null)
    {
        $this->content = $content;
        $this->attributes = AttributesHelper::f($attributesHelper);
    }

    /**
     * @return null|string
     * @author Andreas Glaser
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param $colspan
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function setColspan($colspan)
    {
        $this->attributes->set('colspan', (int)$colspan);

        return $this;
    }

    /**
     * @return null
     * @author Andreas Glaser
     */
    public function getColspan()
    {
        return $this->attributes->get('colspan');
    }

    /**
     * @param $scope
     *
     * @return $this
     * @throws \Exception
     * @author Andreas Glaser
     */
    public function setScope($scope)
    {
        // enforce valid count
        if ($scope !== 'col' && $scope !== 'colgroup' && $scope !== 'row' && $scope !== 'rowgroup') {
            throw new \Exception('Invalid scope provided (:1). Allowed are: col, colgroup, row, rowgroup', [':1' => $scope]);
        }

        $this->attributes->set('scope', $scope);

        return $this;
    }

    /**
     * @return null
     * @author Andreas Glaser
     */
    public function getScope()
    {
        return $this->attributes->get('scope');
    }

    /**
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     * @author Andreas Glaser
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param \AndreasGlaser\Helpers\Interfaces\RendererInterface|null $renderer
     *
     * @return string
     * @author Andreas Glaser
     */
    public function render(RendererInterface $renderer = null)
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        return '<td' . $this->attributes->render() . '>' . $this->content . '</td>';
    }
}