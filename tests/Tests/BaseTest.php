<?php

namespace AndreasGlaser\Helpers\Tests;

/**
 * Class BaseTest
 *
 * @package AndreasGlaser\Helpers\Tests
 */
abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $message
     */
    protected function todo($message = 'todo: Implement this method')
    {
        $this->markTestIncomplete($message);
    }
}