<?php

namespace AndreasGlaser\Helpers\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;

/**
 * Class BaseListHelper
 *
 * @package AndreasGlaser\Helpers\Html\Lists
 */
abstract class BaseListHelper implements FactoryInterface, RenderableInterface
{

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|aaray|null $attributes
     *
     * @return BaseListHelper
     */
    public static function f($attributes = null)
    {
        $className = get_called_class();

        return new $className($attributes);
    }

    /**
     * BaseListHelper constructor.
     *
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributes
     */
    public function __construct($attributes = null)
    {
        $this->attributes = AttributesHelper::f($attributes);

        return $this;
    }

    /**
     * @param                                                         $content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributes
     *
     * @return $this
     */
    public function addItem($content, $attributes = null)
    {
        $index = count($this->items);
        $this->items[$index]['content'] = $content;
        $this->items[$index]['attributes'] = AttributesHelper::f($attributes);

        return $this;
    }
}