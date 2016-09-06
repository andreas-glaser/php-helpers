<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\Validate\Expect;

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
     * @param integer $colSpan
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function setColSpan($colSpan)
    {
        Expect::int($colSpan);

        $this->attributes->set('colspan', (int)$colSpan);

        return $this;
    }

    /**
     * @return null
     * @author Andreas Glaser
     */
    public function getColSpan()
    {
        return $this->attributes->get('colspan');
    }

    /**
     * @param integer $rowSpan
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function setRowSpan($rowSpan)
    {
        Expect::int($rowSpan);

        $this->attributes->set('rowspan', $rowSpan);

        return $this;
    }

    /**
     * @return null
     * @author Andreas Glaser
     */
    public function getRowSpan()
    {
        return $this->attributes->get('rowspan');
    }

    /**
     * @param $scope
     *
     * @return $this
     * @throws \Exception
     * @author     Andreas Glaser
     *
     * @deprecated Not supported in HTML5. http://www.w3schools.com/tags/att_td_scope.asp
     */
    public function setScope($scope)
    {
        $validScopes = ['col', 'row', 'colgroup', 'rowgroup'];

        if (!StringHelper::isOneOf($scope, $validScopes)) {
            throw new \Exception(sprintf('"%s" is not a valid <td> scope. Valid are: %s', $scope, implode(', ', $validScopes)));
        }

        $this->attributes->set('scope', $scope);

        return $this;
    }

    /**
     * @return string|null
     * @author     Andreas Glaser
     *
     * @deprecated Not supported in HTML5. http://www.w3schools.com/tags/att_td_scope.asp
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