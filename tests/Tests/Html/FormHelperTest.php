<?php

namespace AndreasGlaser\Helpers\Tests\Html;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Html\BootstrapHelper;
use AndreasGlaser\Helpers\Html\FormHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class FormHelperTest.
 */
class FormHelperTest extends BaseTest
{
    public function testOpen()
    {
        self::assertEquals('<form action="" method="GET">', FormHelper::open());
        self::assertEquals('<form action="/my-url" method="GET">', FormHelper::open('/my-url'));
        self::assertEquals('<form action="my-url" method="POST">', FormHelper::open('my-url', 'post'));
        self::assertEquals('<form enctype="multipart/form-data" action="my-url" method="POST">', FormHelper::open('my-url', 'post', AttributesHelper::f(['enctype' => 'multipart/form-data'])));
    }

    public function testClose()
    {
        self::assertEquals('</form>', FormHelper::close());
    }

    public function testText()
    {
        self::assertEquals(
            '<input name="biscuit" type="text" value="" />',
            FormHelper::text('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="text" value="Hmmmm" />',
            FormHelper::text('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="text" value="&lt;Hello&gt;" />',
            FormHelper::text('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="text" value="" />',
            FormHelper::text('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testPassword()
    {
        self::assertEquals(
            '<input name="biscuit" type="password" value="" />',
            FormHelper::password('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="password" value="Hmmmm" />',
            FormHelper::password('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="password" value="&lt;Hello&gt;" />',
            FormHelper::password('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="password" value="" />',
            FormHelper::password('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testEmail()
    {
        self::assertEquals(
            '<input name="biscuit" type="email" value="" />',
            FormHelper::email('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="email" value="Hmmmm" />',
            FormHelper::email('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="email" value="&lt;Hello&gt;" />',
            FormHelper::email('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="email" value="" />',
            FormHelper::email('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testColor()
    {
        self::assertEquals(
            '<input name="biscuit" type="color" value="" />',
            FormHelper::color('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="color" value="Hmmmm" />',
            FormHelper::color('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="color" value="&lt;Hello&gt;" />',
            FormHelper::color('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="color" value="" />',
            FormHelper::color('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testDate()
    {
        self::assertEquals(
            '<input name="biscuit" type="date" value="" />',
            FormHelper::date('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="date" value="Hmmmm" />',
            FormHelper::date('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="date" value="&lt;Hello&gt;" />',
            FormHelper::date('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="date" value="" />',
            FormHelper::date('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testDatetime()
    {
        self::assertEquals(
            '<input name="biscuit" type="datetime" value="" />',
            FormHelper::datetime('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="datetime" value="Hmmmm" />',
            FormHelper::datetime('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="datetime" value="&lt;Hello&gt;" />',
            FormHelper::datetime('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="datetime" value="" />',
            FormHelper::datetime('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testDatetimeLocal()
    {
        self::assertEquals(
            '<input name="biscuit" type="datetime-local" value="" />',
            FormHelper::datetimeLocal('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="datetime-local" value="Hmmmm" />',
            FormHelper::datetimeLocal('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="datetime-local" value="&lt;Hello&gt;" />',
            FormHelper::datetimeLocal('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="datetime-local" value="" />',
            FormHelper::datetimeLocal('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testMonth()
    {
        self::assertEquals(
            '<input name="biscuit" type="month" value="" />',
            FormHelper::month('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="month" value="Hmmmm" />',
            FormHelper::month('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="month" value="&lt;Hello&gt;" />',
            FormHelper::month('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="month" value="" />',
            FormHelper::month('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testNumber()
    {
        self::assertEquals(
            '<input name="biscuit" type="number" value="" />',
            FormHelper::number('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="number" value="Hmmmm" />',
            FormHelper::number('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="number" value="&lt;Hello&gt;" />',
            FormHelper::number('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="number" value="" />',
            FormHelper::number('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testRange()
    {
        self::assertEquals(
            '<input name="biscuit" type="range" min="0" max="20" value="10" />',
            FormHelper::range('biscuit', 10, 0, 20)
        );

        self::assertEquals(
            '<input name="peanut" type="range" min="10" max="50" value="33" />',
            FormHelper::range('peanut', 33, 10, 50)
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="range" min="0" max="100" value="100" />',
            FormHelper::range('strawberry', 100, 0, 100, ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="range" min="10" max="20" value="" />',
            FormHelper::range('vegetable[cucumber]', null, 10, 20, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testSearch()
    {
        self::assertEquals(
            '<input name="biscuit" type="search" value="" />',
            FormHelper::search('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="search" value="Hmmmm" />',
            FormHelper::search('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="search" value="&lt;Hello&gt;" />',
            FormHelper::search('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="search" value="" />',
            FormHelper::search('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testTel()
    {
        self::assertEquals(
            '<input name="biscuit" type="tel" value="" />',
            FormHelper::tel('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="tel" value="Hmmmm" />',
            FormHelper::tel('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="tel" value="&lt;Hello&gt;" />',
            FormHelper::tel('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="tel" value="" />',
            FormHelper::tel('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testTime()
    {
        self::assertEquals(
            '<input name="biscuit" type="time" value="" />',
            FormHelper::time('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="time" value="Hmmmm" />',
            FormHelper::time('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="time" value="&lt;Hello&gt;" />',
            FormHelper::time('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="time" value="" />',
            FormHelper::time('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testUrl()
    {
        self::assertEquals(
            '<input name="biscuit" type="url" value="" />',
            FormHelper::url('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="url" value="Hmmmm" />',
            FormHelper::url('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="url" value="&lt;Hello&gt;" />',
            FormHelper::url('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="url" value="" />',
            FormHelper::url('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testWeek()
    {
        self::assertEquals(
            '<input name="biscuit" type="week" value="" />',
            FormHelper::week('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="week" value="Hmmmm" />',
            FormHelper::week('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="week" value="&lt;Hello&gt;" />',
            FormHelper::week('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="week" value="" />',
            FormHelper::week('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testHidden()
    {
        self::assertEquals(
            '<input name="biscuit" type="hidden" value="" />',
            FormHelper::hidden('biscuit')
        );

        self::assertEquals(
            '<input name="peanut" type="hidden" value="Hmmmm" />',
            FormHelper::hidden('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="hidden" value="&lt;Hello&gt;" />',
            FormHelper::hidden('strawberry', '<Hello>', ['id' => 'my-id'])
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="hidden" value="" />',
            FormHelper::hidden('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testTextarea()
    {
        self::assertEquals(
            '<textarea name="biscuit"></textarea>',
            FormHelper::textarea('biscuit')
        );

        self::assertEquals(
            '<textarea name="peanut">Hmmmm</textarea>',
            FormHelper::textarea('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<textarea id="my-id" name="strawberry">&lt;Hello&gt;</textarea>',
            FormHelper::textarea('strawberry', '<Hello>', AttributesHelper::f(['id' => 'my-id']))
        );

        self::assertEquals(
            '<textarea id="delicious" name="vegetable[cucumber]"></textarea>',
            FormHelper::textarea('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testButton()
    {
        self::assertEquals(
            '<button name="biscuit" type="button"></button>',
            FormHelper::button('biscuit')
        );

        self::assertEquals(
            '<button name="peanut" type="button">Hmmmm</button>',
            FormHelper::button('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<button id="my-id" name="strawberry" type="button"><span class="glyphicon glyphicon-plus"></span> Add</button>',
            FormHelper::button('strawberry', BootstrapHelper::glyphIcon('plus') . ' Add', AttributesHelper::f(['id' => 'my-id']))
        );

        self::assertEquals(
            '<button id="delicious" name="vegetable[cucumber]" type="button"></button>',
            FormHelper::button('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testSubmit()
    {
        self::assertEquals(
            '<button name="biscuit" type="submit"></button>',
            FormHelper::submit('biscuit')
        );

        self::assertEquals(
            '<button name="peanut" type="submit">Hmmmm</button>',
            FormHelper::submit('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<button id="my-id" name="strawberry" type="submit"><span class="glyphicon glyphicon-plus"></span> Add</button>',
            FormHelper::submit('strawberry', BootstrapHelper::glyphIcon('plus') . ' Add', AttributesHelper::f(['id' => 'my-id']))
        );

        self::assertEquals(
            '<button id="delicious" name="vegetable[cucumber]" type="submit"></button>',
            FormHelper::submit('vegetable[cucumber]', null, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testLabel()
    {
        self::assertEquals(
            '<label>biscuit</label>',
            FormHelper::label('biscuit')
        );

        self::assertEquals(
            '<label for="Hmmmm">peanut</label>',
            FormHelper::label('peanut', 'Hmmmm')
        );

        self::assertEquals(
            '<label for="Hmmmm" form="cake">peanut</label>',
            FormHelper::label('peanut', 'Hmmmm', 'cake')
        );

        self::assertEquals(
            '<label id="my-id" for="element">&lt;Hello&gt;</label>',
            FormHelper::label('<Hello>', 'element', null, AttributesHelper::f(['id' => 'my-id']))
        );
    }

    public function testCheckbox()
    {
        self::assertEquals(
            '<input name="biscuit" type="checkbox" value="" />',
            FormHelper::checkbox('biscuit', false)
        );

        self::assertEquals(
            '<input name="peanut" type="checkbox" value="Hmmmm" checked="checked" />',
            FormHelper::checkbox('peanut', 'Hmmmm', true)
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="checkbox" value="1" />',
            FormHelper::checkbox('strawberry', 1, false, AttributesHelper::f(['id' => 'my-id']))
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="checkbox" value="123" checked="checked" />',
            FormHelper::checkbox('vegetable[cucumber]', 123, true, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testRadio()
    {
        self::assertEquals(
            '<input name="biscuit" type="radio" value="" />',
            FormHelper::radio('biscuit', false)
        );

        self::assertEquals(
            '<input name="peanut" type="radio" value="Hmmmm" checked="checked" />',
            FormHelper::radio('peanut', 'Hmmmm', true)
        );

        self::assertEquals(
            '<input id="my-id" name="strawberry" type="radio" value="1" />',
            FormHelper::radio('strawberry', 1, false, AttributesHelper::f(['id' => 'my-id']))
        );

        self::assertEquals(
            '<input id="delicious" name="vegetable[cucumber]" type="radio" value="123" checked="checked" />',
            FormHelper::radio('vegetable[cucumber]', 123, true, AttributesHelper::f(['id' => 'delicious']))
        );
    }

    public function testOption()
    {
        self::assertEquals(
            '<option value="frog">Animal</option>',
            FormHelper::option('frog', 'Animal')
        );

        self::assertEquals(
            '<option value="999">&lt;div&gt;Test&lt;/div&gt;</option>',
            FormHelper::option(999, '<div>Test</div>')
        );

        self::assertEquals(
            '<option value="---" selected="selected">Choose...</option>',
            FormHelper::option('---', 'Choose...', true)
        );
    }

    public function testOptGroup()
    {
        self::assertEquals(
            '<optgroup label="frog">Animal</optgroup>',
            FormHelper::optgroup('frog', 'Animal')
        );

        self::assertEquals(
            '<optgroup label="999"><div>Test</div></optgroup>',
            FormHelper::optgroup(999, '<div>Test</div>')
        );

        self::assertEquals(
            '<optgroup data-test="Hello" label="---">Choose...</optgroup>',
            FormHelper::optgroup('---', 'Choose...', ['data-test' => 'Hello'])
        );
    }

    public function testSelect()
    {
        self::assertEquals(
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

    public function testSelectMultiple()
    {
        self::assertEquals(
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
