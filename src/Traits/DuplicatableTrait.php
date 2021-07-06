<?php

namespace AndreasGlaser\Helpers\Traits;

trait DuplicatableTrait
{
    public function duplicate(): self
    {
        return clone $this;
    }
}
