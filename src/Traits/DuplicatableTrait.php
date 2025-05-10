<?php

namespace AndreasGlaser\Helpers\Traits;

/**
 * DuplicatableTrait provides functionality for creating deep copies of objects.
 * 
 * This trait adds a duplicate() method that creates a new instance of the class
 * with the same property values as the original object.
 */
trait DuplicatableTrait
{
    /**
     * Creates a duplicate of the current object.
     * 
     * This method uses PHP's clone operator to create a new instance
     * with the same property values as the original object.
     *
     * @return $this A new instance with the same property values
     */
    public function duplicate()
    {
        $duplicate = clone $this;

        return $duplicate;
    }
}
