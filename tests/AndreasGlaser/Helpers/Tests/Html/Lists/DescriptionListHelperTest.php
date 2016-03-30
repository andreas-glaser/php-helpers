<?php

namespace AndreasGlaser\Helpers\Tests\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\Lists\DescriptionListHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class DescriptionListHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Html\Lists
 * @author  Andreas Glaser
 */
class DescriptionListHelperTest extends BaseTest
{
    /**
     * @author Andreas Glaser
     */
    public function test()
    {
        $unorderedList = DescriptionListHelper::f(['id' => 'my-list']);
        $unorderedList->addItem('Term 1', 'Hello', ['rel' => 'test'], ['data-test' => '123']);
        $unorderedList->addItem('Term 1', 'XYZ', AttributesHelper::f(['data-test' => 'Aww'], ['id' => '321']));

        $this->assertEquals(
            '<dl id="my-list"><dt class="item-first item-index-0" rel="test">Hello</dt><dd class="item-first item-index-0" data-test="123">Hello</dd><dt class="item-last item-index-1" data-test="Aww">XYZ</dt><dd class="item-last item-index-1">XYZ</dd></dl>',
            $unorderedList->render()
        );
    }
}
 