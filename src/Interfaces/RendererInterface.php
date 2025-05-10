<?php

namespace AndreasGlaser\Helpers\Interfaces;

/**
 * RendererInterface defines a contract for classes that render data to a string (e.g., HTML).
 *
 * Classes implementing this interface must provide a render() method that takes data and returns a string representation.
 */
interface RendererInterface
{
    /**
     * Renders the given data to a string (e.g., HTML).
     *
     * @param mixed $data The data to render
     * @return string The rendered output
     */
    public function render($data);
}
