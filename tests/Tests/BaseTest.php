<?php

namespace AndreasGlaser\Helpers\Tests;

use PHPUnit\Framework\TestCase;

/**
 * BaseTest provides a base class for all test cases in the project.
 *
 * This abstract class extends PHPUnit's TestCase and adds common functionality:
 * - A todo() method to mark tests as incomplete
 */
abstract class BaseTest extends TestCase
{
    /**
     * Marks a test as incomplete with a custom message.
     *
     * @param string $message The message to display (default: 'todo: Implement this method')
     */
    protected function todo($message = 'todo: Implement this method')
    {
        self::markTestIncomplete($message);
    }
}
