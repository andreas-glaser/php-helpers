<?php

namespace AndreasGlaser\Helpers\Exceptions;

/**
 * Class IOException
 * 
 * Exception thrown when an I/O error occurs.
 * Extends RuntimeException to provide additional context about the file path where the error occurred.
 */
class IOException extends \RuntimeException
{
    /**
     * @var string|null The file path where the I/O error occurred
     */
    private $path;

    /**
     * IOException constructor
     *
     * @param string    $message  The exception message
     * @param int       $code     The exception code
     * @param \Exception|null $previous The previous exception used for the exception chaining
     * @param string|null $path    The file path where the I/O error occurred
     */
    public function __construct(string $message, int $code = 0, \Exception $previous = null, string $path = null)
    {
        $this->path = $path;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the file path where the I/O error occurred
     *
     * @return string|null The file path or null if not set
     */
    public function getPath()
    {
        return $this->path;
    }
}
