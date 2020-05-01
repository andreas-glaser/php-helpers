<?php

namespace AndreasGlaser\Helpers\Tests;

/**
 * Class BaseTest.
 */
abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $message
     */
    protected function todo($message = 'todo: Implement this method')
    {
        self::markTestIncomplete($message);
    }
}
