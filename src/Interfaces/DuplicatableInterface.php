<?php

namespace AndreasGlaser\Helpers\Interfaces;

/**
 * DuplicatableInterface defines a contract for objects that can be duplicated (deep copied).
 *
 * Classes implementing this interface must provide a duplicate() method that returns a new instance with the same property values.
 */
interface DuplicatableInterface
{
    /**
     * Creates a duplicate (deep copy) of the object.
     *
     * @return static A new instance with the same property values
     */
    public function duplicate();
}
