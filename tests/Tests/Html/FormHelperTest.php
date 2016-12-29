<?php

namespace AndreasGlaser\Helpers\Tests\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\BootstrapHelper;
use AndreasGlaser\Helpers\Html\FormHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class FormHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Html
 * @author  Andreas Glaser
 */
class FormHelperTest extends BaseTest
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
    public function testPassword()
    {
        $this->assertEquals(
            '<input name="biscuit" type="password" value="" />',
            FormHelper::password('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="password" value="Hmmmm" />',
            FormHelper::password('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="password" value="&lt;Hello&gt;" />',
            FormHelper::password('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="password" value="" />',
            FormHelper::password('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testEmail()
    {
        $this->assertEquals(
            '<input name="biscuit" type="email" value="" />',
            FormHelper::email('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="email" value="Hmmmm" />',
            FormHelper::email('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="email" value="&lt;Hello&gt;" />',
            FormHelper::email('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="email" value="" />',
            FormHelper::email('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testColor()
    {
        $this->assertEquals(
            '<input name="biscuit" type="color" value="" />',
            FormHelper::color('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="color" value="Hmmmm" />',
            FormHelper::color('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="color" value="&lt;Hello&gt;" />',
            FormHelper::color('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="color" value="" />',
            FormHelper::color('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testDate()
    {
        $this->assertEquals(
            '<input name="biscuit" type="date" value="" />',
            FormHelper::date('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="date" value="Hmmmm" />',
            FormHelper::date('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="date" value="&lt;Hello&gt;" />',
            FormHelper::date('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="date" value="" />',
            FormHelper::date('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testDatetime()
    {
        $this->assertEquals(
            '<input name="biscuit" type="datetime" value="" />',
            FormHelper::datetime('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="datetime" value="Hmmmm" />',
            FormHelper::datetime('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="datetime" value="&lt;Hello&gt;" />',
            FormHelper::datetime('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="datetime" value="" />',
            FormHelper::datetime('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testDatetimeLocal()
    {
        $this->assertEquals(
            '<input name="biscuit" type="datetime-local" value="" />',
            FormHelper::datetimeLocal('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="datetime-local" value="Hmmmm" />',
            FormHelper::datetimeLocal('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="datetime-local" value="&lt;Hello&gt;" />',
            FormHelper::datetimeLocal('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="datetime-local" value="" />',
            FormHelper::datetimeLocal('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testMonth()
    {
        $this->assertEquals(
            '<input name="biscuit" type="month" value="" />',
            FormHelper::month('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="month" value="Hmmmm" />',
            FormHelper::month('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="month" value="&lt;Hello&gt;" />',
            FormHelper::month('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="month" value="" />',
            FormHelper::month('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testNumber()
    {
        $this->assertEquals(
            '<input name="biscuit" type="number" value="" />',
            FormHelper::number('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="number" value="Hmmmm" />',
            FormHelper::number('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="number" value="&lt;Hello&gt;" />',
            FormHelper::number('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="number" value="" />',
            FormHelper::number('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testRange()
    {
        $this->assertEquals(
            '<input name="biscuit" type="range" min="0" max="20" value="10" />',
            FormHelper::range('biscuit', 10, 0, 20)
        );

        $this->assertEquals(
            '<input name="peanut" type="range" min="10" max="50" value="33" />',
            FormHelper::range('peanut', 33, 10, 50)
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="range" min="0" max="100" value="100" />',
            FormHelper::range('strawberry', 100, 0, 100, ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="range" min="10" max="20" value="" />',
            FormHelper::range('vegetable[cucumber]', null, 10, 20, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testSearch()
    {
        $this->assertEquals(
            '<input name="biscuit" type="search" value="" />',
            FormHelper::search('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="search" value="Hmmmm" />',
            FormHelper::search('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="search" value="&lt;Hello&gt;" />',
            FormHelper::search('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="search" value="" />',
            FormHelper::search('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testTel()
    {
        $this->assertEquals(
            '<input name="biscuit" type="tel" value="" />',
            FormHelper::tel('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="tel" value="Hmmmm" />',
            FormHelper::tel('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="tel" value="&lt;Hello&gt;" />',
            FormHelper::tel('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="tel" value="" />',
            FormHelper::tel('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testTime()
    {
        $this->assertEquals(
            '<input name="biscuit" type="time" value="" />',
            FormHelper::time('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="time" value="Hmmmm" />',
            FormHelper::time('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="time" value="&lt;Hello&gt;" />',
            FormHelper::time('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="time" value="" />',
            FormHelper::time('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testUrl()
    {
        $this->assertEquals(
            '<input name="biscuit" type="url" value="" />',
            FormHelper::url('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="url" value="Hmmmm" />',
            FormHelper::url('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="url" value="&lt;Hello&gt;" />',
            FormHelper::url('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="url" value="" />',
            FormHelper::url('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testWeek()
    {
        $this->assertEquals(
            '<input name="biscuit" type="week" value="" />',
            FormHelper::week('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="week" value="Hmmmm" />',
            FormHelper::week('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="week" value="&lt;Hello&gt;" />',
            FormHelper::week('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="week" value="" />',
            FormHelper::week('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testHidden()
    {
        $this->assertEquals(
            '<input name="biscuit" type="hidden" value="" />',
            FormHelper::hidden('biscuit')
        );

        $this->assertEquals(
            '<input name="peanut" type="hidden" value="Hmmmm" />',
            FormHelper::hidden('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<input id="my-id" name="strawberry" type="hidden" value="&lt;Hello&gt;" />',
            FormHelper::hidden('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        $this->assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="hidden" value="" />',
            FormHelper::hidden('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
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
            '<label>biscuit</label>',
            FormHelper::label('biscuit')
        );

        $this->assertEquals(
            '<label for="Hmmmm">peanut</label>',
            FormHelper::label('peanut', 'Hmmmm')
        );

        $this->assertEquals(
            '<label for="Hmmmm" form="cake">peanut</label>',
            FormHelper::label('peanut', 'Hmmmm', 'cake')
        );

        $this->assertEquals(
            '<label id="my-id" for="element">&lt;Hello&gt;</label>',
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

    /**
     * @author Andreas Glaser
     */
    public function testOption()
    {
        $this->assertEquals(
            '<option value="frog">Animal</option>',
            FormHelper::option('frog', 'Animal')
        );

        $this->assertEquals(
            '<option value="999">&lt;div&gt;Test&lt;/div&gt;</option>',
            FormHelper::option(999, '<div>Test</div>')
        );

        $this->assertEquals(
            '<option value="---" selected="selected">Choose...</option>',
            FormHelper::option('---', 'Choose...', true)
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testOptGroup()
    {
        $this->assertEquals(
            '<optgroup label="frog">Animal</optgroup>',
            FormHelper::optgroup('frog', 'Animal')
        );

        $this->assertEquals(
            '<optgroup label="999"><div>Test</div></optgroup>',
            FormHelper::optgroup(999, '<div>Test</div>')
        );

        $this->assertEquals(
            '<optgroup data-test="Hello" label="---">Choose...</optgroup>',
            FormHelper::optgroup('---', 'Choose...', ['data-test' => 'Hello'])
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testSelect()
    {
        $this->assertEquals(
            '<select id="test" name="partner"><option value="value1">Options One</option><option value="value2">Option Two</option><optgroup label="Group 1"><option value="value4" selected="selected">Option Four</option></optgroup><optgroup label="Group 2"><option value="value5">Option Four</option></optgroup></select>',
            FormHelper::select('partner', [
                'value1'  => 'Options One',
                'value2'  => 'Option Two',
                'Group 1' => [
                    'value4' => 'Option Four',
                ],
                'Group 2' => [
                    'value5' => 'Option Four',
                ],
            ], 'value4', ['id' => 'test']
            )
        );
    }

    /**
     * @author Andreas Glaser
     */
    public function testSelectMultiple()
    {
        $this->assertEquals(
            '<select id="test" name="partner" multiple="multiple"><option value="value1">Options One</option><option value="value2">Option Two</option><optgroup label="Group 1"><option value="value4" selected="selected">Option Four</option></optgroup><optgroup label="Group 2"><option value="value5">Option Four</option></optgroup></select>',
            FormHelper::selectMultiple('partner', [
                'value1'  => 'Options One',
                'value2'  => 'Option Two',
                'Group 1' => [
                    'value4' => 'Option Four',
                ],
                'Group 2' => [
                    'value5' => 'Option Four',
                ],
            ], 'value4', ['id' => 'test']
            )
        );
    }

}