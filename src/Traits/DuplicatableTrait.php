<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * Class DuplicatableTrait
 *
 * @package AndreasGlaser\Helpers\Traits
 * @author  Andreas Glaser
 */
trait DuplicatableTrait
{
    /**
     * @return $this
     * @author Andreas Glaser
     */
    public function duplicate()
    {
        $duplicate = clone $this;

        return $duplicate;
    }
}