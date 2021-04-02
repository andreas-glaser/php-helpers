<?php

namespace AndreasGlaser\Helpers\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseTest.
 */
abstract class BaseTest extends TestCase
{
    /**
     * @param string $message
     */
    protected function todo($message = 'todo: Implement this method')
    {
        self::markTestIncomplete($message);
    }
}
