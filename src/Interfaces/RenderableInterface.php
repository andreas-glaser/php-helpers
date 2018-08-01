<?php

namespace AndreasGlaser\Helpers\Interfaces;

/**
 * Interface RenderableInterface
 *
 * @package AndreasGlaser\Helpers\Interfaces
 */
interface RenderableInterface
{
    public function render(RendererInterface $renderer);
}