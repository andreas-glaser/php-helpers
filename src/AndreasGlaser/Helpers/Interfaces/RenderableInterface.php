<?php

namespace AndreasGlaser\Helpers\Interfaces;

/**
 * Interface RenderableInterface
 *
 * @package AndreasGlaser\Helpers\Interfaces
 * @author  Andreas Glaser
 */
interface RenderableInterface
{
    public function render(RendererInterface $renderer);
}