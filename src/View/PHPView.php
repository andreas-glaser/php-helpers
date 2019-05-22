<?php

namespace AndreasGlaser\Helpers\View;

use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Validate\IOExpect;

/**
 * Class PHPView
 *
 * @package AndreasGlaser\Helpers\View
 */
class PHPView implements FactoryInterface
{
    /**
     * @var array
     */
    protected static $globalData = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var
     */
    protected $file;

    /**
     * PHPView constructor.
     *
     * @param string|null $file
     * @param array       $data
     */
    public function __construct(string $file = null, array $data = [])
    {
        if ($file) {
            $this->setFile($file);
        }

        $this->data = $data;
    }

    /**
     * @param       $file
     * @param array $data
     *
     * @return \AndreasGlaser\Helpers\View\PHPView
     * @deprecated Use PHPView::f()
     */
    public static function factory(string $file = null, array $data = []): PHPView
    {
        return static::f($file, $data);
    }

    /**
     * @param string|null $file
     * @param array       $data
     *
     * @return \AndreasGlaser\Helpers\View\PHPView
     */
    public static function f(string $file = null, array $data = []): PHPView
    {
        return new PHPView($file, $data);
    }

    /**
     * @param string $filePath
     *
     * @return \AndreasGlaser\Helpers\View\PHPView
     */
    public function setFile(string $filePath): self
    {
        IOExpect::isFile($filePath);
        IOExpect::isReadable($filePath);

        $this->file = $filePath;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public static function setGlobal(string $key, $value)
    {
        static::$globalData[$key] = $value;
    }

    /**
     * @return array
     */
    public static function getGlobalData()
    {
        return self::$globalData;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return \AndreasGlaser\Helpers\View\PHPView
     */
    public function set(string $key, $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string|null $file
     *
     * @return string
     * @throws \Exception
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
     * @param string $viewFileName
     * @param array  $data
     * @param array  $global
     *
     * @return string
     * @throws \Exception
     */
    protected function capture(string $viewFileName, array $data = [], array $global = []): string
    {
        extract($global, EXTR_SKIP);
        extract($data, EXTR_SKIP);

        ob_start();

        try {
            require $viewFileName;
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}