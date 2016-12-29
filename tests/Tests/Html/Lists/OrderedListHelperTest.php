<?php

namespace AndreasGlaser\Helpers\Tests\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\Lists\OrderedListHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class OrderedListHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Html\Lists
 * @author  Andreas Glaser
 */
class OrderedListHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function test()
    {
        $unorderedList = OrderedListHelper::f(['id' => 'my-list']);
        $unorderedList->addItem('Hello', ['rel' => 'test']);
        $unorderedList->addItem('XYZ', AttributesHelper::f(['data-test' => 'Aww']));

        $this->assertEquals(
            '<ol id="my-list"><li class="item-first item-index-0" rel="test">Hello</li><li class="item-last item-index-1" data-test="Aww">XYZ</li></ol>',
            $unorderedList->render()
        );
    }
}
 