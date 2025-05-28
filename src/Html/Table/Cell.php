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
 * Represents a table cell (td) or header cell (th) in an HTML table.
 * Implements RenderableInterface for HTML rendering and FactoryInterface for static factory methods.
 */
class Cell implements RenderableInterface, FactoryInterface
{
    /**
     * @var string|null The content of the cell
     */
    protected $content = null;

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper HTML attributes for the cell
     */
    protected $attributes;

    /**
     * @var bool Whether this cell is a header cell (th) or regular cell (td)
     */
    protected $isHeader = false;

    /**
     * Factory method to create a new Cell instance
     *
     * @param string|null                $content         The content of the cell
     * @param AttributesHelper|array|null $attributesHelper HTML attributes for the cell
     * @param bool                       $isHeader        Whether this is a header cell
     *
     * @return \AndreasGlaser\Helpers\Html\Table\Cell
     */
    public static function f($content = null, $attributesHelper = null, bool $isHeader = false): self
    {
        return new Cell($content, $attributesHelper, $isHeader);
    }

    /**
     * Constructor for Cell
     *
     * @param string|null                $content         The content of the cell
     * @param AttributesHelper|array|null $attributesHelper HTML attributes for the cell
     * @param bool                       $isHeader        Whether this is a header cell
     */
    public function __construct(string $content = null, $attributesHelper = null, bool $isHeader = false)
    {
        $this->content = $content;
        $this->attributes = AttributesHelper::f($attributesHelper);
        $this->isHeader = $isHeader;
    }

    /**
     * Get the content of the cell
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the content of the cell
     *
     * @param string $content The content to set
     * @return $this
     */
    public function setContent($content):self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the colspan attribute of the cell
     *
     * @param int $colSpan The number of columns this cell should span
     * @return $this
     */
    public function setColSpan($colSpan):self
    {
        Expect::int($colSpan);

        $this->attributes->set('colspan', (int)$colSpan);

        return $this;
    }

    /**
     * Get the colspan attribute of the cell
     *
     * @return int|null The number of columns this cell spans
     */
    public function getColSpan(): ?int
    {
        return $this->attributes->get('colspan');
    }

    /**
     * Set the rowspan attribute of the cell
     *
     * @param int $rowSpan The number of rows this cell should span
     * @return $this
     */
    public function setRowSpan($rowSpan):self
    {
        Expect::int($rowSpan);

        $this->attributes->set('rowspan', $rowSpan);

        return $this;
    }

    /**
     * Get the rowspan attribute of the cell
     *
     * @return int|null The number of rows this cell spans
     */
    public function getRowSpan(): ?int
    {
        return $this->attributes->get('rowspan');
    }

    /**
     * Set the scope attribute of the cell (deprecated in HTML5)
     *
     * @param string $scope The scope value ('col', 'row', 'colgroup', or 'rowgroup')
     * @return $this
     * @throws \Exception If an invalid scope value is provided
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
     * Get the scope attribute of the cell (deprecated in HTML5)
     *
     * @return string|null The scope value
     * @deprecated Not supported in HTML5. http://www.w3schools.com/tags/att_td_scope.asp
     */
    public function getScope(): ?string
    {
        return $this->attributes->get('scope');
    }

    /**
     * Get the HTML attributes of the cell
     *
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    public function getAttributes(): AttributesHelper
    {
        return $this->attributes;
    }

    /**
     * Check if this cell is a header cell
     *
     * @return bool True if this is a header cell (th), false if it's a regular cell (td)
     */
    public function isHeader(): bool
    {
        return $this->isHeader;
    }

    /**
     * Set whether this cell is a header cell
     *
     * @param bool $isHeader True to make this a header cell (th), false for a regular cell (td)
     * @return Cell
     */
    public function setIsHeader(bool $isHeader): self
    {
        $this->isHeader = $isHeader;

        return $this;
    }

    /**
     * Render the cell as HTML
     *
     * @param RendererInterface|null $renderer Optional custom renderer
     * @return string The rendered HTML cell
     */
    public function render(RendererInterface $renderer = null): string
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
