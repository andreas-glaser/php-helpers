<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\Html\Table\Renderer\Basic;
use AndreasGlaser\Helpers\Html\Table\Row;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;

/**
 * Class TableHelper
 *
 * @package AndreasGlaser\Helpers\Html
 * @author  Andreas Glaser
 */
class TableHelper implements RenderableInterface
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

    public function __construct(array $headRows = [], array $bodyRows = [], AttributesHelper $attributesHelper = null)
    {
        foreach ($headRows AS $headRow) {
            $this->headRow($headRow);
        }

        foreach ($bodyRows AS $bodyRow) {
            $this->bodyRow($bodyRow);
        }

        if (!$attributesHelper) {
            $attributesHelper = new AttributesHelper();
        }

        $this->attributes = $attributesHelper;
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
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributes
     * @return $this
     * @author Andreas Glaser
     */
    public function setAttributes(AttributesHelper $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\Table\Row $rowHelper
     * @return $this
     * @author Andreas Glaser
     */
    public function headRow(Row $rowHelper)
    {
        $this->headRows[] = $rowHelper;

        return $this;
    }

    /**
     * @return \AndreasGlaser\Helpers\Html\Table\Row[]
     * @author Andreas Glaser
     */
    public function getHeadRows()
    {
        return $this->headRows;
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\Table\Row $rowHelper
     * @return $this
     * @author Andreas Glaser
     */
    public function bodyRow(Row $rowHelper)
    {
        $this->bodyRows[] = $rowHelper;

        return $this;
    }

    /**
     * @return \AndreasGlaser\Helpers\Html\Table\Row[]
     * @author Andreas Glaser
     */
    public function getBodyRows()
    {
        return $this->bodyRows;
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\RendererInterface $renderer
     * @author Andreas Glaser
     */
    public function render(RendererInterface $renderer = null)
    {
        if (!$renderer) {
            $renderer = new Basic($this);
        }

        return $renderer->render();
    }
}