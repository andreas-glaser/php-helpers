<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;
use AndreasGlaser\Helpers\StringHelper;
use InvalidArgumentException;

/**
 * AttributesHelper manages HTML element attributes with proper escaping and validation.
 *
 * Features:
 * - Type-safe attribute handling
 * - HTML escaping for security
 * - CSS style parsing and validation
 * - Data attribute management
 * - Class name management
 * 
 * @example
 * ```php
 * // Create a new instance with initial attributes
 * $attrs = AttributesHelper::f(['class' => 'btn']);
 * 
 * // Add more classes and attributes
 * $attrs->addClass('btn-primary')
 *      ->addStyle('margin', '10px')
 *      ->addData('toggle', 'modal');
 * 
 * // Render as HTML attributes string
 * echo $attrs; // outputs: class="btn btn-primary" style="margin:10px" data-toggle="modal"
 * ```
 */
class AttributesHelper implements FactoryInterface, RenderableInterface
{
    private const VALID_ATTRIBUTE_PATTERN = '/^[a-zA-Z0-9_\-]+$/';
    private const VALID_CSS_PROPERTY_PATTERN = '/^[a-zA-Z0-9\-]+$/';

    /** @var string|null */
    private ?string $id = null;

    /** @var array<string, bool> */
    private array $classes = [];

    /** @var array<string, string> */
    private array $data = [];

    /** @var array<string, string> */
    private array $styles = [];

    /** @var array<string, string> */
    private array $attributes = [];

    /**
     * Creates a new AttributesHelper instance.
     *
     * @param array<string, mixed>|null $attributes Initial attributes
     * @throws InvalidArgumentException If invalid attributes are provided
     */
    public function __construct(?array $attributes = null)
    {
        if ($attributes !== null) {
            foreach ($attributes as $name => $value) {
                $this->set($name, $value);
            }
        }
    }

    /**
     * Factory method to create a new instance (deprecated).
     *
     * @param array|null $attributes Initial attributes to set
     * @return self
     * @deprecated Will be removed in 1.0 - use "f()" instead
     */
    public static function create(array $attributes = null): self
    {
        return self::f($attributes);
    }

    /**
     * Factory method to create a new instance.
     *
     * This method implements the FactoryInterface and is the recommended way to create
     * new instances of AttributesHelper. If an AttributesHelper instance is passed,
     * it will be returned as is. Otherwise, a new instance will be created.
     *
     * @param AttributesHelper|array|null $input Initial attributes or existing instance
     * @return static
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
     * Sets an attribute with validation.
     *
     * @param string $name The attribute name
     * @param mixed $value The attribute value
     * @return $this
     * @throws InvalidArgumentException If attribute name is invalid
     */
    public function set(string $name, mixed $value): self
    {
        $name = mb_strtolower($name);
        
        if (!preg_match(self::VALID_ATTRIBUTE_PATTERN, $name)) {
            throw new InvalidArgumentException("Invalid attribute name: $name");
        }

        if ($name === 'id') {
            return $this->setId((string)$value);
        }
        
        if ($name === 'class') {
            return $this->addClass((string)$value);
        }
        
        if ($name === 'style') {
            return $this->parseStyles((string)$value);
        }
        
        if (str_starts_with($name, 'data-')) {
            return $this->addData(substr($name, 5), $value);
        }

        $this->attributes[$name] = (string)$value;
        return $this;
    }

    /**
     * Sets the ID attribute.
     *
     * @param string $value The ID value
     * @return $this
     * @throws InvalidArgumentException If ID is invalid
     */
    public function setId(string $value): self
    {
        if (!preg_match(self::VALID_ATTRIBUTE_PATTERN, $value)) {
            throw new InvalidArgumentException("Invalid ID value: $value");
        }
        
        $this->id = $value;
        return $this;
    }

    /**
     * Adds one or more CSS classes.
     *
     * @param string|array $classes Space-separated classes or array of classes
     * @return $this
     */
    public function addClass(string|array $classes): self
    {
        $classArray = is_array($classes) ? $classes : StringHelper::explodeAndTrim(' ', $classes);
        
        foreach ($classArray as $class) {
            if (preg_match(self::VALID_ATTRIBUTE_PATTERN, $class)) {
                $this->classes[$class] = true;
            }
        }

        return $this;
    }

    /**
     * Adds a data attribute with proper escaping.
     *
     * @param string $name The data attribute name (without 'data-' prefix)
     * @param mixed $value The attribute value
     * @return $this
     * @throws InvalidArgumentException If name is invalid
     */
    public function addData(string $name, mixed $value): self
    {
        if (!preg_match(self::VALID_ATTRIBUTE_PATTERN, $name)) {
            throw new InvalidArgumentException("Invalid data attribute name: $name");
        }

        $this->data[$name] = (string)$value;
        return $this;
    }

    /**
     * Adds a style property with validation.
     *
     * @param string $property The CSS property
     * @param string $value The CSS value
     * @return $this
     * @throws InvalidArgumentException If property name is invalid
     */
    public function addStyle(string $property, string $value): self
    {
        $property = trim($property);
        
        if (!preg_match(self::VALID_CSS_PROPERTY_PATTERN, $property)) {
            throw new InvalidArgumentException("Invalid CSS property: $property");
        }

        $this->styles[$property] = trim($value);
        return $this;
    }

    /**
     * Parses a CSS style string safely.
     *
     * @param string $styleString The CSS style string
     * @return $this
     */
    private function parseStyles(string $styleString): self
    {
        // Handle complex values with semicolons (like urls)
        preg_match_all('/([^:;]+):([^;]+)(?:;|$)/', $styleString, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            if (isset($match[1], $match[2])) {
                $this->addStyle($match[1], $match[2]);
            }
        }

        return $this;
    }

    /**
     * Creates an immutable copy with modifications.
     *
     * @param callable $modifier Function to modify the attributes
     * @return static
     */
    public function with(callable $modifier): static
    {
        $copy = clone $this;
        $modifier($copy);
        return $copy;
    }

    /**
     * Renders the attributes as an HTML string.
     *
     * @param RendererInterface|null $renderer Optional custom renderer
     * @return string The rendered HTML attributes
     */
    public function render(?RendererInterface $renderer = null): string
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $parts = [];

        if ($this->id !== null) {
            $parts[] = 'id="' . HtmlHelper::chars($this->id) . '"';
        }

        if (!empty($this->classes)) {
            $parts[] = 'class="' . HtmlHelper::chars(implode(' ', array_keys($this->classes))) . '"';
        }

        foreach ($this->attributes as $name => $value) {
            $parts[] = $name . '="' . HtmlHelper::chars($value) . '"';
        }

        foreach ($this->data as $key => $value) {
            $parts[] = 'data-' . $key . '="' . HtmlHelper::chars($value) . '"';
        }

        if (!empty($this->styles)) {
            $styles = [];
            foreach ($this->styles as $property => $value) {
                $styles[] = $property . ':' . $value;
            }
            $parts[] = 'style="' . HtmlHelper::chars(implode(';', $styles)) . '"';
        }

        return empty($parts) ? '' : ' ' . implode(' ', $parts);
    }

    /**
     * Gets all attributes as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        if ($this->id !== null) {
            $result['id'] = $this->id;
        }

        if (!empty($this->classes)) {
            $result['class'] = implode(' ', array_keys($this->classes));
        }

        foreach ($this->data as $key => $value) {
            $result['data-' . $key] = $value;
        }

        if (!empty($this->styles)) {
            $styleStrings = [];
            foreach ($this->styles as $property => $value) {
                $styleStrings[] = $property . ':' . $value;
            }
            $result['style'] = implode(';', $styleStrings);
        }

        return array_merge($result, $this->attributes);
    }

    /**
     * String representation of the attributes.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    // Getter methods for immutability

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return array<string, bool>
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @return array<string, string>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array<string, string>
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * @return array<string, string>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
