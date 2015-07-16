<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * Class Row
 *
 * @package AndreasGlaser\Helpers\Html\Table
 * @author  Andreas Glaser
 */
class Row
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
     * @var bool
     */
    protected $isHead = false;

    /**
     * @param array                                        $cells
     * @param bool                                         $isHead
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributesHelper
     */
    public function __construct(array $cells = [], $isHead = false, AttributesHelper $attributesHelper = null)
    {
        foreach ($cells AS $cell) {
            $this->addCell($cell);
        }

        $this->isHead = (bool)$isHead;

        if (!$attributesHelper) {
            $attributesHelper = new AttributesHelper();
        }

        $this->attributes = $attributesHelper;
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\Table\Cell $cellHelper
     * @return $this
     * @author Andreas Glaser
     */
    public function addCell(Cell $cellHelper)
    {
        $this->cells[] = $cellHelper;

        return $this;
    }

    /**
     * @return \AndreasGlaser\Helpers\Html\Table\Cell[]
     * @author Andreas Glaser
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @return boolean
     * @author Andreas Glaser
     */
    public function getIsHead()
    {
        return $this->isHead;
    }

    /**
     * @param boolean $isHead
     * @return $this
     * @author Andreas Glaser
     */
    public function setIsHead($isHead)
    {
        $this->isHead = (bool)$isHead;

        return $this;
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
}