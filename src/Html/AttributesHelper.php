<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\Traits\DuplicatableTrait;

/**
 * Class AttributesHelper
 * 
 * Helper class for managing HTML element attributes.
 * Provides methods for handling common HTML attributes like id, class, style, and data attributes.
 * Implements FactoryInterface for static factory methods and RenderableInterface for HTML rendering.
 */
class AttributesHelper implements FactoryInterface, RenderableInterface
{
    use DuplicatableTrait;

    /**
     * @var string|null The HTML element's ID attribute
     */
    protected $id = null;

    /**
     * @var array Associative array of CSS classes
     */
    protected $classes = [];

    /**
     * @var array Associative array of data attributes
     */
    protected $data = [];

    /**
     * @var array Associative array of inline styles
     */
    protected $styles = [];

    /**
     * @var array Associative array of custom attributes
     */
    protected $attributes = [];

    /**
     * Factory method to create a new instance (deprecated)
     *
     * @param array|null $attributes Initial attributes to set
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     * @deprecated Will be removed in 1.0 - use "Object::f()" instead
     */
    public static function create(array $attributes = null): self
    {
        return self::f($attributes);
    }

    /**
     * Factory method to create a new instance
     *
     * @param AttributesHelper|array|null $input Initial attributes or existing AttributesHelper instance
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    public static function f($input = null): static
    {
        if ($input instanceof AttributesHelper) {
            return $input;
        } else {
            return new AttributesHelper($input);
        }
    }

    /**
     * Constructor
     *
     * @param array|null $attributes Initial attributes to set
     */
    public function __construct(array $attributes = null)
    {
        if (null !== $attributes) {
            foreach ($attributes as $name => $value) {
                $this->set($name, $value);
            }
        }
    }

    /**
     * Sets a custom attribute
     *
     * @param string $name  The attribute name
     * @param mixed  $value The attribute value
     * @return $this
     */
    public function set($name, $value):self
    {
        $name = \mb_strtolower($name);
        if ('id' === $name) {
            $this->setId($value);
        } elseif ('class' === $name) {
            $this->addClass($value);
        } elseif ('style' === $name) {
            $pieces = \explode(';', $value);
            foreach ($pieces as $definition) {
                $p = \explode(':', $definition);
                if (isset($p[0]) && isset($p[1])) {
                    $this->addStyle($p[0], $p[1]);
                }
            }
        } elseif (StringHelper::startsWith('data-', $name)) {
            $this->addData(\mb_substr($name, 5), $value);
        } else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Checks if a custom attribute has been set
     *
     * @param string $name The attribute name to check
     * @return bool True if the attribute exists
     */
    public function has($name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Gets a custom attribute value
     *
     * @param string $name    The attribute name
     * @param mixed  $default Default value if attribute doesn't exist
     * @return mixed The attribute value or default
     */
    public function get($name, $default = null): mixed
    {
        return $this->has($name) ? $this->attributes[$name] : $default;
    }

    /**
     * Sets the ID attribute
     *
     * @param string $value The ID value
     * @return $this
     */
    public function setId($value):self
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Checks if ID attribute has been set
     *
     * @return bool True if ID exists
     */
    public function hasId(): bool
    {
        return !\is_null($this->id);
    }

    /**
     * Gets the ID attribute value
     *
     * @param mixed $default Default value if ID doesn't exist
     * @return string|null The ID value or default
     */
    public function getId($default = null): ?string
    {
        return $this->hasId() ? $this->id : $default;
    }

    /**
     * Removes the ID attribute
     *
     * @return $this
     */
    public function removeId():self
    {
        $this->id = null;

        return $this;
    }

    /**
     * Adds one or more CSS classes
     *
     * @param string|array $name Class name(s) to add
     * @return $this
     */
    public function addClass($name):self
    {
        $classes = StringHelper::explodeAndTrim(' ', $name);
        foreach ($classes as $className) {
            $this->classes[$className] = $className;
        }

        return $this;
    }

    /**
     * Checks if a CSS class has been added
     *
     * @param string $name The class name to check
     * @return bool True if the class exists
     */
    public function hasClass($name): bool
    {
        return isset($this->classes[$name]);
    }

    /**
     * Checks if any CSS classes have been added
     *
     * @return bool True if any classes exist
     */
    public function hasClasses(): bool
    {
        return !empty($this->classes);
    }

    /**
     * Removes a CSS class
     *
     * @param string $name The class name to remove
     * @return $this
     */
    public function removeClass($name):self
    {
        if ($this->hasClass($name)) {
            unset($this->classes[$name]);
        }

        return $this;
    }

    /**
     * Gets all CSS classes
     *
     * @return array Associative array of class names
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * Adds an inline style
     *
     * @param string $name  The style property name
     * @param string $value The style property value
     * @return $this
     */
    public function addStyle($name, $value):self
    {
        $this->styles[$name] = $value;

        return $this;
    }

    /**
     * Checks if a style has been added
     *
     * @param string $name The style property name to check
     * @return bool True if the style exists
     */
    public function hasStyle($name): bool
    {
        return isset($this->styles[$name]);
    }

    /**
     * Checks if any styles have been added
     *
     * @return bool True if any styles exist
     */
    public function hasStyles(): bool
    {
        return !empty($this->styles);
    }

    /**
     * Removes a style
     *
     * @param string $name The style property name to remove
     * @return $this
     */
    public function removeStyle($name):self
    {
        if ($this->hasStyle($name)) {
            unset($this->styles[$name]);
        }

        return $this;
    }

    /**
     * Gets all styles
     *
     * @return array Associative array of style properties and values
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * Adds a data attribute
     * Example: <span data-mydata="hello"></span>
     *
     * @param string $name  The data attribute name (without 'data-' prefix)
     * @param mixed  $value The data attribute value
     * @return $this
     */
    public function addData($name, $value):self
    {
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Checks if specific or any data attributes have been added
     *
     * @param string|null $name The data attribute name to check (without 'data-' prefix)
     * @return bool True if the data attribute exists or if any data attributes exist
     */
    public function hasData($name = null): bool
    {
        return \is_null($name) ? !empty($this->data) : isset($this->data[$name]);
    }

    /**
     * Gets all or a single data attribute
     *
     * @param string|null $name    The data attribute name (without 'data-' prefix)
     * @param mixed       $default Default value if attribute doesn't exist
     * @return array|mixed The data attribute value(s) or default
     */
    public function getData($name = null, $default = null): mixed
    {
        return $this->hasData($name) ? (\is_null($name) ? $this->data : $this->data[$name]) : $default;
    }

    /**
     * Removes a data attribute
     *
     * @param string $name The data attribute name to remove (without 'data-' prefix)
     * @return $this
     */
    public function removeData($name):self
    {
        if ($this->hasData($name)) {
            unset($this->data[$name]);
        }

        return $this;
    }

    /**
     * Gets all CSS classes as an imploded string
     *
     * @param string $glue The string to use between class names
     * @return string The imploded class names
     */
    public function getClassesImploded($glue = ' '): string
    {
        return \implode($glue, $this->classes);
    }

    /**
     * Renders the attributes as an HTML string
     *
     * @param RendererInterface|null $renderer Optional custom renderer
     * @return string The rendered HTML attributes
     */
    public function render(RendererInterface $renderer = null): string
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $attributes = '';

        if ($this->hasId()) {
            $attributes = 'id="' . $this->getId() . '"';
        }

        if ($this->hasClasses()) {
            $attributes .= ' class="' . HtmlHelper::chars($this->getClassesImploded()) . '"';
        }

        foreach ($this->attributes as $name => $value) {
            $attributes .= ' ' . $name . '="' . HtmlHelper::chars($value) . '"';
        }

        $data = $this->getData();

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $attributes .= ' data-' . $key . '="' . $value . '"';
            }
        }

        $styles = $this->getStyles();

        if (!empty($styles)) {
            $stylesCompiled = '';
            foreach ($styles as $name => $value) {
                $stylesCompiled .= $name . ':' . $value . ';';
            }

            $attributes .= ' style="' . $stylesCompiled . '"';
        }

        $attributes = \trim($attributes);

        return !empty($attributes) ? ' ' . $attributes : '';
    }

    /**
     * Gets all attributes as an associative array
     *
     * @return array The attributes as an array
     */
    public function getAsArray(): array
    {
        $return = [];

        if ($id = $this->getId()) {
            $return['id'] = $id;
        }

        if (\count($this->getClasses())) {
            $return['class'] = $this->getClassesImploded();
        }

        foreach ($this->getData() as $key => $value) {
            $return['data-' . $key] = $value;
        }

        foreach ($this->attributes as $key => $value) {
            $return[$key] = $value;
        }

        return $return;
    }

    /**
     * String representation of the attributes
     *
     * @return string The rendered HTML attributes
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
