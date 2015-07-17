<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\Traits\DuplicatableTrait;

/**
 * Class AttributesHelper
 *
 * @package AndreasGlaser\Helpers\Html
 * @author  Andreas Glaser
 */
class AttributesHelper
{
    use DuplicatableTrait;

    protected $id = null;
    protected $classes = [];
    protected $data = [];
    protected $attributes = [];

    /**
     * @param array $attributes
     *
     * @return AttributesHelper
     *
     * @author Andreas Glaser
     */
    public static function create(array $attributes = null)
    {
        return new AttributesHelper($attributes);
    }

    public function __construct(array $attributes = null)
    {
        if ($attributes !== null) {
            foreach ($attributes AS $name => $value) {
                $this->set($name, $value);
            }
        }
    }

    /**
     * Sets custom attribute.
     *
     * @param $name
     * @param $value
     *
     * @return $this
     *
     * @author Andreas Glaser
     */
    public function set($name, $value)
    {
        $name = mb_strtolower($name);
        if ($name === 'id') {
            $this->setId($value);
        } elseif ($name === 'class') {
            $this->addClass($value);
        } else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Checks if custom attribute has been set.
     *
     * @param $name
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public function has($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Gets custom attribute.
     *
     * @param      $name
     * @param null $default
     *
     * @return null
     *
     * @author Andreas Glaser
     */
    public function get($name, $default = null)
    {
        return $this->has($name) ? $this->attributes[$name] : $default;
    }

    /**
     * Sets id attribute.
     *
     * @param $value
     *
     * @return $this
     *
     * @author Andreas Glaser
     */
    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Cheks if id attribute has been set.
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public function hasId()
    {
        return !is_null($this->id);
    }

    /**
     * Gets id attribute.
     *
     * @param null $default
     *
     * @return null
     *
     * @author Andreas Glaser
     */
    public function getId($default = null)
    {
        return $this->hasId() ? $this->id : $default;
    }

    /**
     * Removeds id attribute.
     *
     * @return $this
     *
     * @author Andreas Glaser
     */
    public function removeId()
    {
        $this->id = null;

        return $this;
    }

    /**
     * Adds class.
     *
     * @param $name
     *
     * @return $this
     *
     * @author Andreas Glaser
     */
    public function addClass($name)
    {
        $classes = StringHelper::explodeAndTrim(' ', $name);
        foreach ($classes AS $className) {
            $this->classes[$className] = $className;
        }

        return $this;
    }

    /**
     * Checks if class has been added.
     *
     * @param $name
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public function hasClass($name)
    {
        return isset($this->classes[$name]);
    }

    /**
     * Checks if any classes have been added.
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public function hasClasses()
    {
        return !empty($this->classes);
    }

    /**
     * Removes class.
     *
     * @param $name
     *
     * @return $this
     *
     * @author Andreas Glaser
     */
    public function removeClass($name)
    {
        if ($this->hasClass($name)) {
            unset($this->classes[$name]);
        }

        return $this;
    }

    /**
     * Gets all classes
     *
     * @return array
     *
     * @author Andreas Glaser
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Adds data attribute.
     * e.g. <span data-mydata="hello"></span>
     *
     * @param $name
     * @param $value
     *
     * @return $this
     *
     * @author Andreas Glaser
     */
    public function addData($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Checks if specific or any data has been added.
     *
     * @param null $name
     *
     * @return bool
     *
     * @author Andreas Glaser
     */
    public function hasData($name = null)
    {
        return is_null($name) ? !empty($this->data) : isset($this->data[$name]);
    }

    /**
     * Gets all or single data attribute.
     *
     * @param null $name
     * @param null $default
     *
     * @return array|null
     *
     * @author Andreas Glaser
     */
    public function getData($name = null, $default = null)
    {
        return $this->hasData($name) ? (is_null($name) ? $this->data : $this->data[$name]) : $default;
    }

    /**
     * Removed data.
     *
     * @param $name
     *
     * @return $this
     *
     * @author Andreas Glaser
     */
    public function removeData($name)
    {
        if ($this->hasData($name)) {
            unset($this->data[$name]);
        }

        return $this;
    }

    /**
     * Returns classes exploded.
     *
     * @param string $glue
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public function getClassesImploded($glue = ' ')
    {
        return implode($glue, $this->classes);
    }

    /**
     * Renders attributes into string.
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public function render()
    {
        $attributes = null;

        if ($this->hasId()) {
            $attributes = 'id="' . $this->getId() . '"';
        }

        if ($this->hasClasses()) {
            $attributes .= ' class="' . HtmlHelper::chars($this->getClassesImploded()) . '"';
        }

        foreach ($this->attributes AS $name => $value) {
            $attributes .= ' ' . $name . '="' . HtmlHelper::chars($value) . '"';
        }

        $data = $this->getData();

        if ($data) {
            foreach ($data AS $key => $value) {
                $attributes .= ' data-' . $key . '="' . $value . '"';
            }
        }

        return ' ' . trim($attributes);
    }

    /**
     * @return array
     * @author Andreas Glaser
     */
    public function getAsArray()
    {
        $return = [];

        if ($id = $this->getId()) {
            $return['id'] = $id;
        }

        if (count($this->getClasses())) {
            $return['class'] = $this->getClassesImploded();
        }

        foreach ($this->getData() AS $key => $value) {
            $return['data-' . $key] = $value;
        }

        foreach ($this->attributes AS $key => $value) {
            $return[$key] = $value;
        }

        return $return;
    }

    /**
     * Executes render method.
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public function __toString()
    {
        return $this->render();
    }
}