<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;
use AndreasGlaser\Helpers\StringHelper;
use AndreasGlaser\Helpers\Traits\DuplicatableTrait;

/**
 * Class AttributesHelper.
 */
class AttributesHelper implements FactoryInterface, RenderableInterface
{
    use DuplicatableTrait;

    /**
     * @var string|null
     */
    protected $id = null;
    /**
     * @var array
     */
    protected $classes = [];
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $styles = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     *
     * @deprecated Will be removed in 1.0 - use "Object::f()" instead
     */
    public static function create(array $attributes = null)
    {
        return self::f($attributes);
    }

    /**
     * Factory.
     *
     * @param AttributesHelper|array|null $input
     *
     * @return \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    public static function f($input = null)
    {
        if ($input instanceof self) {
            return $input;
        } else {
            return new self($input);
        }
    }

    /**
     * @param array $attributes
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
     * Sets custom attribute.
     *
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function set($name, $value): self
    {
        $name = mb_strtolower($name);
        if ('id' === $name) {
            $this->setId($value);
        } elseif ('class' === $name) {
            $this->addClass($value);
        } elseif ('style' === $name) {
            $pieces = explode(';', $value);
            foreach ($pieces as $definition) {
                $p = explode(':', $definition);
                if (isset($p[0], $p[1])) {
                    $this->addStyle($p[0], $p[1]);
                }
            }
        } elseif (StringHelper::startsWith('data-', $name)) {
            $this->addData(mb_substr($name, 5), $value);
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
     */
    public function setId($value): self
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Cheks if id attribute has been set.
     *
     * @return bool
     */
    public function hasId()
    {
        return !\is_null($this->id);
    }

    /**
     * Gets id attribute.
     *
     * @param null $default
     *
     * @return null
     */
    public function getId($default = null)
    {
        return $this->hasId() ? $this->id : $default;
    }

    /**
     * Removeds id attribute.
     *
     * @return $this
     */
    public function removeId(): self
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
     */
    public function addClass($name): self
    {
        $classes = StringHelper::explodeAndTrim(' ', $name);
        foreach ($classes as $className) {
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
     */
    public function hasClass($name)
    {
        return isset($this->classes[$name]);
    }

    /**
     * Checks if any classes have been added.
     *
     * @return bool
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
     */
    public function removeClass($name): self
    {
        if ($this->hasClass($name)) {
            unset($this->classes[$name]);
        }

        return $this;
    }

    /**
     * Gets all classes.
     *
     * @return array
     */
    public function getClasses()
    {
        return $this->classes;
    }

    public function addStyle($name, $value): self
    {
        $this->styles[$name] = $value;

        return $this;
    }

    /**
     * Checks if style has been added.
     *
     * @param $name
     *
     * @return bool
     */
    public function hasStyle($name)
    {
        return isset($this->styles[$name]);
    }

    /**
     * Checks if any styles have been added.
     *
     * @return bool
     */
    public function hasStyles()
    {
        return !empty($this->styles);
    }

    /**
     * Removes style.
     *
     * @param $name
     *
     * @return $this
     */
    public function removeStyle($name): self
    {
        if ($this->hasStyle($name)) {
            unset($this->styles[$name]);
        }

        return $this;
    }

    /**
     * Gets all styles.
     *
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Adds data attribute.
     * e.g. <span data-mydata="hello"></span>.
     *
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function addData($name, $value): self
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
     */
    public function hasData($name = null)
    {
        return \is_null($name) ? !empty($this->data) : isset($this->data[$name]);
    }

    /**
     * Gets all or single data attribute.
     *
     * @param null $name
     * @param null $default
     *
     * @return array|null
     */
    public function getData($name = null, $default = null)
    {
        return $this->hasData($name) ? (\is_null($name) ? $this->data : $this->data[$name]) : $default;
    }

    /**
     * Removed data.
     *
     * @param $name
     *
     * @return $this
     */
    public function removeData($name): self
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
     */
    public function getClassesImploded($glue = ' ')
    {
        return implode($glue, $this->classes);
    }

    /**
     * @return string
     */
    public function render(RendererInterface $renderer = null)
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $attributes = null;

        if ($this->hasId()) {
            $attributes = 'id="' . $this->getId() . '"';
        }

        if ($this->hasClasses()) {
            $attributes .= ' class="' . HtmlHelper::chars($this->getClassesImploded()) . '"';
        }

        foreach ($this->attributes as $name => $value) {
            $attributes .= ' ' . $name . '="' . HtmlHelper::chars($value ?? '') . '"';
        }

        $data = $this->getData();

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $attributes .= ' data-' . $key . '="' . $value . '"';
            }
        }

        $styles = $this->getStyles();

        if (!empty($styles)) {
            $stylesCompiled = null;
            foreach ($styles as $name => $value) {
                $stylesCompiled .= $name . ':' . $value . ';';
            }

            $attributes .= ' style="' . $stylesCompiled . '"';
        }

        $attributes = trim($attributes);

        return !empty($attributes) ? ' ' . $attributes : '';
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        $return = [];

        if ($id = $this->getId()) {
            $return['id'] = $id;
        }

        if (true === \count($this->getClasses())) {
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
     * Executes render method.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
