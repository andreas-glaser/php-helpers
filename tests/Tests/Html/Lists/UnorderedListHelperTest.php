<?php

namespace AndreasGlaser\Helpers\Tests\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\Lists\UnorderedListHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class UnorderedListHelperTest.
 */
class UnorderedListHelperTest extends BaseTest
{
    public function test()
    {
        $unorderedList = UnorderedListHelper::f(['id' => 'my-list']);
        $unorderedList->addItem('Hello', ['rel' => 'test']);
        $unorderedList->addItem('XYZ', AttributesHelper::f(['data-test' => 'Aww']));

        self::assertEquals(
            '<ul id="my-list"><li class="item-first item-index-0" rel="test">Hello</li><li class="item-last item-index-1" data-test="Aww">XYZ</li></ul>',
            $unorderedList->render()
        );
    }
}
