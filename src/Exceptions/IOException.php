<?php

namespace AndreasGlaser\Helpers\Exceptions;

class IOException extends \RuntimeException
{
    private ?string $path;

    public function __construct(string $message, int $code = 0, \Exception $previous = null, ?string $path = null)
    {
        $this->path = $path;

        parent::__construct($message, $code, $previous);
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
