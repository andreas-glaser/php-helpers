<?php

namespace AndreasGlaser\Helpers\Tests;

/**
 * Class BaseTest
 *
 * @package AndreasGlaser\Helpers\Tests
 * @author  Andreas Glaser
 */
abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $message
     *
     * @author Andreas Glaser
     */
    protected function todo($message = 'todo: Implement this method')
    {
        $this->markTestIncomplete($message);
    }
}