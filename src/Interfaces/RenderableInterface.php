<?php

namespace AndreasGlaser\Helpers\Interfaces;

/**
 * RenderableInterface defines a contract for objects that can be rendered to a string (e.g., HTML).
 *
 * Classes implementing this interface must provide a render() method that returns a string representation.
 */
interface RenderableInterface
{
    /**
     * Renders the object to a string (e.g., HTML).
     *
     * @param RendererInterface $renderer Optional custom renderer
     * @return string The rendered output
     */
    public function render(RendererInterface $renderer): string;
}
