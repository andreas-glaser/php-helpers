<?php

namespace AndreasGlaser\Helpers\View;

use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Validate\Expect;

/**
 * Class PHPView
 *
 * @package AndreasGlaser\Helpers\View
 * @author  Andreas Glaser
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
     *
     * @author Andreas Glaser
     */
    public function __construct($file = null, array $data = [])
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
     * @author     Andreas Glaser
     *
     * @deprecated Use PHPView::f()
     */
    public static function factory($file = null, array $data = [])
    {
        return static::f($file, $data);
    }

    /**
     * @param $file
     * @param $data
     *
     * @return \AndreasGlaser\Helpers\View\PHPView
     * @author Andreas Glaser
     */
    public static function f($file = null, array $data = [])
    {
        return new PHPView($file, $data);
    }

    /**
     * @param string $filePath
     *
     * @return $this
     * @throws \Exception
     * @author Andreas Glaser
     */
    public function setFile($filePath)
    {
        Expect::str($filePath);

        if (!file_exists($filePath)) {
            throw new \Exception(strtr('The requested view :file could not be found', [
                ':file' => $filePath,
            ]));
        }

        if (!is_readable($filePath)) {
            throw new \Exception(strtr('The requested view :file could not be read', [
                ':file' => $filePath,
            ]));
        }

        $this->file = $filePath;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @author Andreas Glaser
     */
    public static function setGlobal($key, $value)
    {
        static::$globalData[$key] = $value;
    }

    /**
     * @return array
     * @author Andreas Glaser
     */
    public static function getGlobalData()
    {
        return self::$globalData;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return array
     * @author Andreas Glaser
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $file
     *
     * @return string
     * @throws \Exception
     * @author Andreas Glaser
     */
    public function render($file = null)
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
     * @author Andreas Glaser
     */
    protected function capture($viewFileName, array $data = [], array $global = [])
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
     * @author Andreas Glaser
     */
    public function __toString()
    {
        return $this->render();
    }
}