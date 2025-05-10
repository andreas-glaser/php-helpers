<?php

namespace AndreasGlaser\Helpers\View;

use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Validate\IOExpect;

/**
 * PHPView provides functionality for rendering PHP templates with data.
 * 
 * This class:
 * - Loads and renders PHP template files
 * - Supports both local and global template data
 * - Implements FactoryInterface for static factory methods
 * - Handles template file validation and error handling
 */
class PHPView implements FactoryInterface
{
    /**
     * @var array Stores global data accessible to all views
     */
    protected static $globalData = [];

    /**
     * @var array Stores local data for this view instance
     */
    protected $data = [];

    /**
     * @var string The path to the template file
     */
    protected $file;

    /**
     * Creates a new PHPView instance.
     *
     * @param string|null $file The path to the template file
     * @param array $data Initial data to pass to the template
     */
    public function __construct(string $file = null, array $data = [])
    {
        if ($file) {
            $this->setFile($file);
        }

        $this->data = $data;
    }

    /**
     * Factory method to create a new PHPView instance.
     *
     * @param string|null $file The path to the template file
     * @param array $data Initial data to pass to the template
     *
     * @return \AndreasGlaser\Helpers\View\PHPView A new view instance
     *
     * @deprecated Use PHPView::f() instead
     */
    public static function factory(string $file = null, array $data = []): PHPView
    {
        return static::f($file, $data);
    }

    /**
     * Factory method to create a new PHPView instance.
     *
     * @param string|null $file The path to the template file
     * @param array $data Initial data to pass to the template
     *
     * @return \AndreasGlaser\Helpers\View\PHPView A new view instance
     */
    public static function f(string $file = null, array $data = []): PHPView
    {
        return new PHPView($file, $data);
    }

    /**
     * Sets the template file to use for rendering.
     *
     * @param string $filePath The path to the template file
     *
     * @return $this For method chaining
     *
     * @throws \AndreasGlaser\Helpers\Exceptions\IOException If the file doesn't exist or isn't readable
     */
    public function setFile(string $filePath): self
    {
        IOExpect::isFile($filePath);
        IOExpect::isReadable($filePath);

        $this->file = $filePath;

        return $this;
    }

    /**
     * Sets a global value accessible to all views.
     *
     * @param string $key The key to store the value under
     * @param mixed $value The value to store
     */
    public static function setGlobal(string $key, $value)
    {
        static::$globalData[$key] = $value;
    }

    /**
     * Gets all global data.
     *
     * @return array All global data
     */
    public static function getGlobalData()
    {
        return self::$globalData;
    }

    /**
     * Sets a local value for this view instance.
     *
     * @param string $key The key to store the value under
     * @param mixed $value The value to store
     *
     * @return $this For method chaining
     */
    public function set(string $key, $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Gets all local data for this view instance.
     *
     * @return array All local data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Renders the template with the current data.
     *
     * @param string|null $file Optional template file to use instead of the current one
     *
     * @return string The rendered template
     *
     * @throws \Exception If no template file is set
     */
    public function render(string $file = null): string
    {
        if ($file) {
            $this->setFile($file);
        }

        if (empty($this->file)) {
            throw new \Exception('You must set the file to use within your view before rendering');
        }

        return $this->capture($this->file, $this->data, static::$globalData);
    }

    /**
     * Captures the output of a template file with the given data.
     *
     * @param string $viewFileName The path to the template file
     * @throws \Exception
     */
    protected function capture(string $viewFileName, array $data = [], array $global = []): string
    {
        \extract($global, EXTR_SKIP);
        \extract($data, EXTR_SKIP);

        \ob_start();

        try {
            require $viewFileName;
        } catch (\Exception $e) {
            \ob_end_clean();
            throw $e;
        }

        return \ob_get_clean();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
