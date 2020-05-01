<?php

namespace AndreasGlaser\Helpers\Exceptions;

/**
 * Class IOException.
 */
class IOException extends \RuntimeException
{
    /**
     * @var string
     */
    private $path;

    /**
     * IOException constructor.
     */
    public function __construct(string $message, int $code = 0, \Exception $previous = null, string $path = null)
    {
        $this->path = $path;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
