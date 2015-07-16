<?php

namespace AndreasGlaser\Helpers\Html\Table\Renderer;

use AndreasGlaser\Helpers\Html\TableHelper;
use AndreasGlaser\RendererInterface;

/**
 * Class Basic
 *
 * @package AndreasGlaser\Helpers\Html\Table\Renderer
 * @author  Andreas Glaser
 */
class Basic implements RendererInterface
{
    /**
     * @var \AndreasGlaser\Helpers\Html\TableHelper
     */
    protected $tableHelper;

    public function __construct(TableHelper $tableHelper)
    {
        $this->tableHelper = $tableHelper;
    }

    public function render()
    {
        // todo: render table
    }
}
