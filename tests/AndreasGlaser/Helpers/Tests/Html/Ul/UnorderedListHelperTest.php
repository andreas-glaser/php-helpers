<?php

namespace AndreasGlaser\Helpers\Test\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\Ul\UnorderedListHelper;

/**
 * Class StringHelperTest
 *
 * @package Helpers\Test
 *
 * @author  Andreas Glaser
 */
class UnorderedListHelperTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $list = UnorderedListHelper::create(AttributesHelper::create(['id' => 'test']));
        $list->li('Hi there', AttributesHelper::create(['class' => 'cheese']));

        echo $list;

    }
}
 