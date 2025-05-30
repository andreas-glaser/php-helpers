<?php

namespace AndreasGlaser\Helpers\Interfaces;

/**
 * FactoryInterface defines a contract for classes that provide a static factory method.
 *
 * Classes implementing this interface must provide a static f() method for instantiation.
 * Each implementing class can define its own parameters as needed for factory instantiation.
 * The interface doesn't enforce specific parameter signatures to allow maximum flexibility.
 */
interface FactoryInterface
{
    /**
     * Static factory method for creating a new instance of the class.
     *
     * Note: Implementing classes should define their own parameter signature
     * based on their specific instantiation requirements.
     *
     * @return static A new instance of the implementing class
     */
    public static function f(): static;
}
