<?php

namespace AndreasGlaser\Helpers\Tests\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\BootstrapHelper;
use AndreasGlaser\Helpers\Html\FormHelper;

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
    public function testOpen()
    {
        $this->assertEquals('<form action="" method="GET">', FormHelper::open());
        $this->assertEquals('<form action="/my-url" method="GET">', FormHelper::open('/my-url'));
        $this->assertEquals('<form action="my-url" method="POST">', FormHelper::open('my-url', 'post'));
        $this->assertEquals('<form enctype="multipart/form-data" action="my-url" method="POST">', FormHelper::open('my-url', 'post', AttributesHelper::f(['enctype' => 'multipart/form-data'])));
    }

    /**
     * @author Andreas Glaser
     */
    public function testClose()
    {
        $this->assertEquals('</form>', FormHelper::close());
    }

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
            FormHelper::text('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="text" value="" />',
            FormHelper::text('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
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
            FormHelper::textarea('strawberry', '<Hello>', AttributesHelper::f(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<textarea id="delicious" name="vegetable[cucumber]"></textarea>',
            FormHelper::textarea('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
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
            FormHelper::button('strawberry', BootstrapHelper::glyphIcon('plus') . ' Add', AttributesHelper::f(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<button id="delicious" name="vegetable[cucumber]" type="button"></button>',
            FormHelper::button('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
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
            FormHelper::submit('strawberry', BootstrapHelper::glyphIcon('plus') . ' Add', AttributesHelper::f(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<button id="delicious" name="vegetable[cucumber]" type="submit"></button>',
            FormHelper::submit('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testLabel()
    {
        $this->assertEquals(
            '<label>biscuit<label>',
            FormHelper::label('biscuit')
        );

        $this->assertEquals(
            '<label for="Hmmmm">peanut<label>',
            FormHelper::label('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<label for="Hmmmm" form="cake">peanut<label>',
            FormHelper::label('peanut', 'Hmmmm', 'cake')
        );

        $this->assertEquals(
            '<label id="my-id" for="element">&lt;Hello&gt;<label>',
            FormHelper::label('<Hello>', 'element', null, AttributesHelper::f(['id' => 'my-id']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testCheckbox()
    {
        $this->assertEquals(
            '<input name="biscuit" type="checkbox" value="" />',
            FormHelper::checkbox('biscuit', false)
        );

        $this->assertEquals(
            '<input name="peanut" type="checkbox" value="Hmmmm" checked="checked" />',
            FormHelper::checkbox('peanut', 'Hmmmm', true)
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="checkbox" value="1" />',
            FormHelper::checkbox('strawberry', 1, false, AttributesHelper::f(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="checkbox" value="123" checked="checked" />',
            FormHelper::checkbox('vegetable[cucumber]', 123, true, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testRadio()
    {
        $this->assertEquals(
            '<input name="biscuit" type="radio" value="" />',
            FormHelper::radio('biscuit', false)
        );

        $this->assertEquals(
            '<input name="peanut" type="radio" value="Hmmmm" checked="checked" />',
            FormHelper::radio('peanut', 'Hmmmm', true)
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="radio" value="1" />',
            FormHelper::radio('strawberry', 1, false, AttributesHelper::f(['id' => 'my-id']))
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="radio" value="123" checked="checked" />',
            FormHelper::radio('vegetable[cucumber]', 123, true, AttributesHelper::f(['id' => 'delicious']))
        );
    }
}