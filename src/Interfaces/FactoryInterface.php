<?php

namespace AndreasGlaser\Helpers\Interfaces;

/**
 * FactoryInterface defines a contract for classes that provide a static factory method.
 *
 * Classes implementing this interface must provide a static f() method for instantiation.
 */
interface FactoryInterface
{
    /**
     * Static factory method for creating a new instance of the class.
     *
     * @return static A new instance of the implementing class
     */
    public static function f(): static;
}
