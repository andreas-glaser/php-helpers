<?php

namespace AndreasGlaser\Helpers\Tests\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\BootstrapHelper;
use AndreasGlaser\Helpers\Html\FormHelper;
use AndreasGlaser\Helpers\HtmlHelper;

/**
 * Class FormHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Html
 * @author  Andreas Glaser
 */
class FormHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @author Andreas Glaser
     */
    public function testText()
    {
        $this->assertEquals(
            '<input name="biscuit" type="text" value="" />',
            FormHelper::text('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="text" value="Hmmmm" />',
            FormHelper::text('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="text" value="&lt;Hello&gt;" />',
            FormHelper::text('strawberry', '<Hello>', AttributesHelper::create(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="text" value="" />',
            FormHelper::text('vegetable[cucumber]', null, AttributesHelper::create(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testTextarea()
    {
        $this->assertEquals(
            '<textarea name="biscuit"></textarea>',
            FormHelper::textarea('biscuit')
        );

        $this->assertEquals(
            '<textarea name="peanut">Hmmmm</textarea>',
            FormHelper::textarea('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<textarea id="my-id" name="strawberry">&lt;Hello&gt;</textarea>',
            FormHelper::textarea('strawberry', '<Hello>', AttributesHelper::create(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<textarea id="delicious" name="vegetable[cucumber]"></textarea>',
            FormHelper::textarea('vegetable[cucumber]', null, AttributesHelper::create(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testButton()
    {
        $this->assertEquals(
            '<button name="biscuit" type="button"></button>',
            FormHelper::button('biscuit')
        );

        $this->assertEquals(
            '<button name="peanut" type="button">Hmmmm</button>',
            FormHelper::button('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<button id="my-id" name="strawberry" type="button"><span class="glyphicon glyphicon-plus"></span> Add</button>',
            FormHelper::button('strawberry', BootstrapHelper::glyphIcon('plus') . ' Add', AttributesHelper::create(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<button id="delicious" name="vegetable[cucumber]" type="button"></button>',
            FormHelper::button('vegetable[cucumber]', null, AttributesHelper::create(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testSubmit()
    {
        $this->assertEquals(
            '<button name="biscuit" type="submit"></button>',
            FormHelper::submit('biscuit')
        );

        $this->assertEquals(
            '<button name="peanut" type="submit">Hmmmm</button>',
            FormHelper::submit('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<button id="my-id" name="strawberry" type="submit"><span class="glyphicon glyphicon-plus"></span> Add</button>',
            FormHelper::submit('strawberry', BootstrapHelper::glyphIcon('plus') . ' Add', AttributesHelper::create(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<button id="delicious" name="vegetable[cucumber]" type="submit"></button>',
            FormHelper::submit('vegetable[cucumber]', null, AttributesHelper::create(['id' => 'delicious']))
        );
    }
}