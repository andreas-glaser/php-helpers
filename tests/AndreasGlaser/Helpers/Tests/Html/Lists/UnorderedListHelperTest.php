<?php

namespace AndreasGlaser\Helpers\Tests\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\Lists\UnorderedListHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class UnorderedListHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Html\Lists
 * @author  Andreas Glaser
 */
class UnorderedListHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function test()
    {
        $unorderedList = UnorderedListHelper::f(['id' => 'my-list']);
        $unorderedList->addItem('Hello', ['rel' => 'test']);
        $unorderedList->addItem('XYZ', AttributesHelper::f(['data-test' => 'Aww']));

        $this->assertEquals(
            '<ul id="my-list"><li class="item-first item-index-0" rel="test">Hello</li><li class="item-last item-index-1" data-test="Aww">XYZ</li></ul>',
            $unorderedList->render()
        );
    }
}
 