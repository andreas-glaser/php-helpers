<?php

namespace AndreasGlaser\Helpers\Html\Table;

use AndreasGlaser\Helpers\Html\AttributesHelper;

class Cell
{
    /**
     * @var string|null
     */
    protected $content = null;

    /**
     * @var int
     */
    protected $colspan = 1;

    /**
     * @var string
     */
    protected $scope = 'col';

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $attributes;

    /**
     * @param null                                         $content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributesHelper
     */
    public function __construct($content = null, AttributesHelper $attributesHelper = null)
    {
        if (!$attributesHelper) {
            $attributesHelper = new AttributesHelper();
        }

        $this->attributes = $attributesHelper;
    }

    /**
     * @return null
     * @author Andreas Glaser
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     * @return $this
     * @author Andreas Glaser
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return int
     * @author Andreas Glaser
     */
    public function getColspan()
    {
        return $this->colspan;
    }

    /**
     * @param int $colspan
     * @return $this
     * @author Andreas Glaser
     */
    public function setColspan($colspan)
    {
        $this->colspan = (int)$colspan;

        return $this;
    }

    /**
     * @return string
     * @author Andreas Glaser
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     * @return $this
     * @author Andreas Glaser
     */
    public function setScope($scope)
    {
        // enforce valid count
        if ($scope !== 'col' && $scope !== 'colgroup' && $scope !== 'row' && $scope !== 'rowgroup') {
            throw new \Exception('Invalid scope provided (:1). Allowd are: col, colgroup, row, rowgroup', [':1' => $scope]);
        }

        $this->scope = $scope;

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