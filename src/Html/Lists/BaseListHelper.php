<?php

namespace AndreasGlaser\Helpers\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;

/**
 * BaseListHelper provides a base class for HTML list helpers.
 *
 * This abstract class implements common functionality for list helpers:
 * - Managing list items and their attributes
 * - Adding items to the list
 * - Factory method for instantiation
 *
 * Subclasses should implement the render() method for specific list types.
 */
abstract class BaseListHelper implements FactoryInterface, RenderableInterface
{
    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper HTML attributes for the list element
     */
    protected $attributes;

    /**
     * @var array List items and their attributes
     */
    protected $items = [];

    /**
     * Factory method to create a new list helper instance.
     *
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributes HTML attributes for the list
     *
     * @return static A new instance of the list helper
     */
    public static function f($attributes = null): static
    {
        $className = \get_called_class();

        return new $className($attributes);
    }

    /**
     * BaseListHelper constructor.
     *
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributes HTML attributes for the list
     */
    public function __construct($attributes = null)
    {
        $this->attributes = AttributesHelper::f($attributes);
    }

    /**
     * Adds an item to the list.
     *
     * @param mixed $content The content of the list item
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributes HTML attributes for the item
     *
     * @return $this For method chaining
     */
    public function addItem($content, $attributes = null):self
    {
        $index = \count($this->items);
        $this->items[$index]['content'] = $content;
        $this->items[$index]['attributes'] = AttributesHelper::f($attributes);

        return $this;
    }
}
