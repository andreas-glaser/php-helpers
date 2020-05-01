<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * Class DuplicatableTrait.
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
