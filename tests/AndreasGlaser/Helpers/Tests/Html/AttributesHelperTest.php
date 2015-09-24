<?php

namespace AndreasGlaser\Helpers\Tests\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * Class AttributesHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Html
 * @author  Andreas Glaser
 */
class AttributesHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @author Andreas Glaser
     */
    public function testAttributes()
    {
        $attributesHelper = new AttributesHelper();
        $attributesHelper
            ->setId('myid')
            ->addClass('myclass')
            ->addData('mydata1', 'cheese')
            ->addData('mydata2', 'bacon')
            ->set('href', 'http://andreas.glaser.me');

        $this->assertEquals(
            ' id="myid" class="myclass" href="http://andreas.glaser.me" data-mydata1="cheese" data-mydata2="bacon"',
            $attributesHelper->render()
        );

        $attributesHelper->removeClass('myclass');
        $attributesHelper->removeData('mydata2');
        $attributesHelper->removeId();

        $this->assertEquals(
            ' href="http://andreas.glaser.me" data-mydata1="cheese"',
            $attributesHelper->render()
        );

        $this->assertEquals(
            ' id="my-id" class="testclass" data-important="info" data-cheese="delicious"',
            AttributesHelper::create(['id' => 'my-id', 'CLASS' => 'testclass', 'data-important' => 'info', 'data-cheese' => 'delicious'])->render()
        );
    }
}
 