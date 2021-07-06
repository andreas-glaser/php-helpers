<?php

namespace AndreasGlaser\Helpers\View;

use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Validate\IOExpect;

class PHPView implements FactoryInterface
{
    protected static array $globalData = [];
    protected array $data = [];
    protected ?string $file;

    public function __construct(string $file = null, array $data = [])
    {
        if ($file) {
            $this->setFile($file);
        }

        $this->data = $data;
    }

    /**
     * @param $file
     *
     * @return \AndreasGlaser\Helpers\View\PHPView
     *
     * @deprecated Use PHPView::f()
     */
    public static function factory(string $file = null, array $data = []): self
    {
        return static::f($file, $data);
    }

    /**
     * @return \AndreasGlaser\Helpers\View\PHPView
     */
    public static function f(string $file = null, array $data = []): self
    {
        return new self($file, $data);
    }

    /**
     * @return \AndreasGlaser\Helpers\View\PHPView
     */
    public function setFile(string $filePath): self
    {
        IOExpect::isFile($filePath);
        IOExpect::isReadable($filePath);

        $this->file = $filePath;

        return $this;
    }

    public static function setGlobal(string $key, $value): void
    {
        static::$globalData[$key] = $value;
    }

    public static function getGlobalData(): array
    {
        return self::$globalData;
    }

    public function set(string $key, $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
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

    public function __toString(): string
    {
        return $this->render();
    }
}
