<?php

namespace AndreasGlaser\Helpers\Test\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * Class StringHelperTest
 *
 * @package Helpers\Test
 *
 * @author  Andreas Glaser
 */
class AttributesHelperTest extends \PHPUnit_Framework_TestCase
{

    public function testAttributes()
    {
        $attributesHelper = new AttributesHelper();
        $attributesHelper
            ->setId('myid')
            ->addClass('myclass')
            ->addData('mydata1', 'cheese')
            ->addData('mydata2', 'bacon')
            ->set('href', 'http://andreas.glaser.me');

        $this->assertTrue($attributesHelper->render() === ' id="myid" class="myclass" href="http://andreas.glaser.me" data-mydata1="cheese" data-mydata2="bacon"');

        $attributesHelper->removeClass('myclass');
        $attributesHelper->removeData('mydata2');
        $attributesHelper->removeId();

        $this->assertTrue($attributesHelper->render() === ' href="http://andreas.glaser.me" data-mydata1="cheese"');
    }
}
 