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
     */
    public static function f($content = null, $attributesHelper = null)
    {
        return new Cell($content, $attributesHelper);
    }

    /**
     * @param null                        $content
     * @param AttributesHelper|array|null $attributesHelper
     */
    public function __construct($content = null, $attributesHelper = null)
    {
        $this->content = $content;
        $this->attributes = AttributesHelper::f($attributesHelper);
    }

    /**
     * @return null|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     *
     * @return $this
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
     */
    public function setColSpan($colSpan)
    {
        Expect::int($colSpan);

        $this->attributes->set('colspan', (int)$colSpan);

        return $this;
    }

    /**
     * @return null
     */
    public function getColSpan()
    {
        return $this->attributes->get('colspan');
    }

    /**
     * @param integer $rowSpan
     *
     * @return $this
     */
    public function setRowSpan($rowSpan)
    {
        Expect::int($rowSpan);

        $this->attributes->set('rowspan', $rowSpan);

        return $this;
    }

    /**
     * @return null
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
     * @deprecated Not supported in HTML5. http://www.w3schools.com/tags/att_td_scope.asp
     */
    public function getScope()
    {
        return $this->attributes->get('scope');
    }

    /**
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    public function getAttributes()
    {
        return $this->attributes;
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

        return '<td' . $this->attributes->render() . '>' . $this->content . '</td>';
    }
}