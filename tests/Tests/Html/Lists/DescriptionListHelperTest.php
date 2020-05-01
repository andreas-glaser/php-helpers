<?php

namespace AndreasGlaser\Helpers\Tests\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\Lists\DescriptionListHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class DescriptionListHelperTest.
 */
class DescriptionListHelperTest extends BaseTest
{
    public function test()
    {
        $descriptionListHelper = DescriptionListHelper::f(['id' => 'my-list']);
        $descriptionListHelper->addItem('Term 1', 'Hello', ['rel' => 'test'], ['data-test' => '123']);
        $descriptionListHelper->addItem('Term 1', 'XYZ', AttributesHelper::f(['data-test' => 'Aww']), ['id' => '321']);

        self::assertEquals(
            '<dl id="my-list"><dt class="item-first item-index-0" rel="test">Term 1</dt><dd class="item-first item-index-0" data-test="123">Hello</dd><dt class="item-last item-index-1" data-test="Aww">Term 1</dt><dd id="321" class="item-last item-index-1">XYZ</dd></dl>',
            $descriptionListHelper->render()
        );
    }
}
