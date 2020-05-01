<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\Validate\Expect;

/**
 * Class Cell.
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

    protected $isHeader = false;

    /**
     * @param null                        $content
     * @param AttributesHelper|array|null $attributesHelper
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Cell
     */
    public static function f($content = null, $attributesHelper = null, bool $isHeader = false)
    {
        return new Cell($content, $attributesHelper, $isHeader);
    }

    /**
     * @param AttributesHelper|array|null $attributesHelper
     */
    public function __construct(string $content = null, $attributesHelper = null, bool $isHeader = false)
    {
        $this->content = $content;
        $this->attributes = AttributesHelper::f($attributesHelper);
        $this->isHeader = $isHeader;
    }

    /**
     * @return string|null
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
    public function setContent($content):self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param int $colSpan
     *
     * @return $this
     */
    public function setColSpan($colSpan):self
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
     * @param int $rowSpan
     *
     * @return $this
     */
    public function setRowSpan($rowSpan):self
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
     *
     * @throws \Exception
     *
     * @deprecated Not supported in HTML5. http://www.w3schools.com/tags/att_td_scope.asp
     */
    public function setScope($scope):self
    {
        $validScopes = ['col', 'row', 'colgroup', 'rowgroup'];

        if (!StringHelper::isOneOf($scope, $validScopes)) {
            throw new \Exception(\sprintf('"%s" is not a valid <td> scope. Valid are: %s', $scope, \implode(', ', $validScopes)));
        }

        $this->attributes->set('scope', $scope);

        return $this;
    }

    /**
     * @return string|null
     *
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

    public function isHeader(): bool
    {
        return $this->isHeader;
    }

    /**
     * @return Cell
     */
    public function setIsHeader(bool $isHeader): self
    {
        $this->isHeader = $isHeader;

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

        if (true === $this->isHeader()) {
            return \sprintf('<th%s>%s</th>', $this->attributes->render(), $this->content);
        }

        return \sprintf('<td%s>%s</td>', $this->attributes->render(), $this->content);
    }
}
