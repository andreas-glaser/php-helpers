<?php

namespace AndreasGlaser\Helpers\View;

/**
 * Class PHPView
 *
 * This is a stripped down version of:
 * https://github.com/kohana/core/blob/0b511b13e13f04064f28cfcef8a2f9cc8d12c268/classes/Kohana/View.php
 *
 * @package AndreasGlaser\Helpers\View
 * @author  Andreas Glaser
 */
class PHPView
{
    protected static $globalData = [];
    protected $file;
    protected $data = [];

    public function __construct($file = null, array $data = null)
    {
        if ($file) {
            $this->setFile($file);
        }

        if ($data) {
            $this->data = $data + $this->data;
        }
    }

    public static function factory($file, array $data)
    {
        return new PHPView($file, $data);
    }

    public function setFile($file)
    {
        if (!file_exists($file)) {
            throw new \Exception(strtr('The requested view :file could not be found', [
                ':file' => $file,
            ]));
        }

        if (!is_readable($file)) {
            throw new \Exception(strtr('The requested view :file could not be read', [
                ':file' => $file,
            ]));
        }

        $this->file = $file;

        return $this;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public static function setGlobal($key, $value)
    {
        static::$globalData[$key] = $value;
    }

    protected static function capture($fileName, array $data)
    {
        extract($data, EXTR_SKIP);

        if (!empty(static::$globalData)) {
            extract(static::$globalData, EXTR_SKIP | EXTR_REFS);
        }

        ob_start();

        try {
            require $fileName;
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }
    
    public function render($file = null)
    {
        if ($file) {
            $this->setFile($file);
        }

        if (empty($this->file)) {
            throw new \Exception('You must set the file to use within your view before rendering');
        }

        return static::capture($this->file, $this->data);
    }

    public function __toString()
    {
        return $this->render();
    }
}