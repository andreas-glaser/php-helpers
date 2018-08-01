<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * Class DuplicatableTrait
 *
 * @package AndreasGlaser\Helpers\Traits
 */
trait DuplicatableTrait
{
    /**
     * @return $this
     */
    public function duplicate()
    {
        $duplicate = clone $this;

        return $duplicate;
    }
}