<?php

namespace Tests\Html;

use PHPUnit\Framework\TestCase;
use AndreasGlaser\Helpers\Html\FormHelper;
use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * FormHelperTest provides unit tests for the FormHelper class.
 *
 * This class tests HTML form generation methods:
 * - Form opening and closing tags
 * - Various input types (text, password, email, etc.)
 * - Textarea and button elements
 * - Label elements
 * - Select and option elements with optgroups
 * - Checkbox and radio inputs
 * - Attribute handling and HTML escaping
 * - Edge cases and complex scenarios
 * 
 * Each method is tested with valid inputs, invalid inputs, edge cases,
 * and proper HTML output with correct attribute rendering.
 */
class FormHelperTest extends TestCase
{
    // ========================================
    // Tests for open() and close() methods
    // ========================================

    /**
     * Tests the open() method with default parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::open
     * @return void
     */
    public function testOpenWithDefaults()
    {
        $result = FormHelper::open();
        $this->assertEquals('<form action="" method="GET">', $result);
    }

    /**
     * Tests the open() method with action and method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::open
     * @return void
     */
    public function testOpenWithActionAndMethod()
    {
        $result = FormHelper::open('/submit', 'POST');
        $this->assertEquals('<form action="/submit" method="POST">', $result);
    }

    /**
     * Tests the open() method with additional attributes as array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::open
     * @return void
     */
    public function testOpenWithAttributesArray()
    {
        $result = FormHelper::open('/submit', 'POST', ['id' => 'contact-form', 'class' => 'form-horizontal']);
        
        $this->assertStringContainsString('<form', $result);
        $this->assertStringContainsString('action="/submit"', $result);
        $this->assertStringContainsString('method="POST"', $result);
        $this->assertStringContainsString('id="contact-form"', $result);
        $this->assertStringContainsString('class="form-horizontal"', $result);
        $this->assertStringContainsString('>', $result);
    }

    /**
     * Tests the open() method with AttributesHelper instance.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::open
     * @return void
     */
    public function testOpenWithAttributesHelper()
    {
        $attrs = new AttributesHelper(['enctype' => 'multipart/form-data', 'novalidate' => 'novalidate']);
        $result = FormHelper::open('/upload', 'POST', $attrs);
        
        $this->assertStringContainsString('action="/upload"', $result);
        $this->assertStringContainsString('method="POST"', $result);
        $this->assertStringContainsString('enctype="multipart/form-data"', $result);
        $this->assertStringContainsString('novalidate="novalidate"', $result);
    }

    /**
     * Tests the open() method with method case conversion.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::open
     * @return void
     */
    public function testOpenWithMethodCaseConversion()
    {
        $result = FormHelper::open(null, 'post');
        $this->assertStringContainsString('method="POST"', $result);
        
        $result = FormHelper::open(null, 'get');
        $this->assertStringContainsString('method="GET"', $result);
    }

    /**
     * Tests the close() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::close
     * @return void
     */
    public function testClose()
    {
        $result = FormHelper::close();
        $this->assertEquals('</form>', $result);
    }

    // ========================================
    // Tests for text input methods
    // ========================================

    /**
     * Tests the text() method with basic parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::text
     * @return void
     */
    public function testTextWithBasicParameters()
    {
        $result = FormHelper::text('username', 'john_doe');
        
        $this->assertStringContainsString('<input', $result);
        $this->assertStringContainsString('name="username"', $result);
        $this->assertStringContainsString('type="text"', $result);
        $this->assertStringContainsString('value="john_doe"', $result);
        $this->assertStringContainsString('/>', $result);
    }

    /**
     * Tests the text() method with null value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::text
     * @return void
     */
    public function testTextWithNullValue()
    {
        $result = FormHelper::text('username');
        
        $this->assertStringContainsString('name="username"', $result);
        $this->assertStringContainsString('type="text"', $result);
        $this->assertStringContainsString('value=""', $result);
    }

    /**
     * Tests the text() method with additional attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::text
     * @return void
     */
    public function testTextWithAttributes()
    {
        $result = FormHelper::text('email', 'test@example.com', [
            'id' => 'email-field',
            'class' => 'form-control',
            'placeholder' => 'Enter your email',
            'required' => 'required'
        ]);
        
        $this->assertStringContainsString('name="email"', $result);
        $this->assertStringContainsString('type="text"', $result);
        $this->assertStringContainsString('value="test@example.com"', $result);
        $this->assertStringContainsString('id="email-field"', $result);
        $this->assertStringContainsString('class="form-control"', $result);
        $this->assertStringContainsString('placeholder="Enter your email"', $result);
        $this->assertStringContainsString('required="required"', $result);
    }

    /**
     * Tests the password() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::password
     * @return void
     */
    public function testPassword()
    {
        $result = FormHelper::password('password', 'secret123');
        
        $this->assertStringContainsString('name="password"', $result);
        $this->assertStringContainsString('type="password"', $result);
        $this->assertStringContainsString('value="secret123"', $result);
    }

    /**
     * Tests the email() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::email
     * @return void
     */
    public function testEmail()
    {
        $result = FormHelper::email('user_email', 'user@domain.com', ['autocomplete' => 'email']);
        
        $this->assertStringContainsString('name="user_email"', $result);
        $this->assertStringContainsString('type="email"', $result);
        $this->assertStringContainsString('value="user@domain.com"', $result);
        $this->assertStringContainsString('autocomplete="email"', $result);
    }

    // ========================================
    // Tests for specialized input types
    // ========================================

    /**
     * Tests the color() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::color
     * @return void
     */
    public function testColor()
    {
        $result = FormHelper::color('theme_color', '#ff5733');
        
        $this->assertStringContainsString('name="theme_color"', $result);
        $this->assertStringContainsString('type="color"', $result);
        $this->assertStringContainsString('value="#ff5733"', $result);
    }

    /**
     * Tests the date() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::date
     * @return void
     */
    public function testDate()
    {
        $result = FormHelper::date('birth_date', '1990-05-15', ['min' => '1900-01-01', 'max' => '2025-12-31']);
        
        $this->assertStringContainsString('name="birth_date"', $result);
        $this->assertStringContainsString('type="date"', $result);
        $this->assertStringContainsString('value="1990-05-15"', $result);
        $this->assertStringContainsString('min="1900-01-01"', $result);
        $this->assertStringContainsString('max="2025-12-31"', $result);
    }

    /**
     * Tests the datetime() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::datetime
     * @return void
     */
    public function testDatetime()
    {
        $result = FormHelper::datetime('appointment', '2024-03-15T14:30:00');
        
        $this->assertStringContainsString('name="appointment"', $result);
        $this->assertStringContainsString('type="datetime"', $result);
        $this->assertStringContainsString('value="2024-03-15T14:30:00"', $result);
    }

    /**
     * Tests the datetimeLocal() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::datetimeLocal
     * @return void
     */
    public function testDatetimeLocal()
    {
        $result = FormHelper::datetimeLocal('local_time', '2024-03-15T14:30');
        
        $this->assertStringContainsString('name="local_time"', $result);
        $this->assertStringContainsString('type="datetime-local"', $result);
        $this->assertStringContainsString('value="2024-03-15T14:30"', $result);
    }

    /**
     * Tests the month() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::month
     * @return void
     */
    public function testMonth()
    {
        $result = FormHelper::month('report_month', '2024-03');
        
        $this->assertStringContainsString('name="report_month"', $result);
        $this->assertStringContainsString('type="month"', $result);
        $this->assertStringContainsString('value="2024-03"', $result);
    }

    /**
     * Tests the number() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::number
     * @return void
     */
    public function testNumber()
    {
        $result = FormHelper::number('quantity', '5', ['min' => '1', 'max' => '100', 'step' => '1']);
        
        $this->assertStringContainsString('name="quantity"', $result);
        $this->assertStringContainsString('type="number"', $result);
        $this->assertStringContainsString('value="5"', $result);
        $this->assertStringContainsString('min="1"', $result);
        $this->assertStringContainsString('max="100"', $result);
        $this->assertStringContainsString('step="1"', $result);
    }

    /**
     * Tests the range() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::range
     * @return void
     */
    public function testRange()
    {
        $result = FormHelper::range('volume', 50, 0, 100, ['step' => '5']);
        
        $this->assertStringContainsString('name="volume"', $result);
        $this->assertStringContainsString('type="range"', $result);
        $this->assertStringContainsString('min="0"', $result);
        $this->assertStringContainsString('max="100"', $result);
        $this->assertStringContainsString('value="50"', $result);
        $this->assertStringContainsString('step="5"', $result);
    }

    /**
     * Tests the search() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::search
     * @return void
     */
    public function testSearch()
    {
        $result = FormHelper::search('query', 'search term', ['placeholder' => 'Search...']);
        
        $this->assertStringContainsString('name="query"', $result);
        $this->assertStringContainsString('type="search"', $result);
        $this->assertStringContainsString('value="search term"', $result);
        $this->assertStringContainsString('placeholder="Search..."', $result);
    }

    /**
     * Tests the tel() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::tel
     * @return void
     */
    public function testTel()
    {
        $result = FormHelper::tel('phone', '+1-555-123-4567');
        
        $this->assertStringContainsString('name="phone"', $result);
        $this->assertStringContainsString('type="tel"', $result);
        $this->assertStringContainsString('value="+1-555-123-4567"', $result);
    }

    /**
     * Tests the time() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::time
     * @return void
     */
    public function testTime()
    {
        $result = FormHelper::time('meeting_time', '14:30');
        
        $this->assertStringContainsString('name="meeting_time"', $result);
        $this->assertStringContainsString('type="time"', $result);
        $this->assertStringContainsString('value="14:30"', $result);
    }

    /**
     * Tests the url() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::url
     * @return void
     */
    public function testUrl()
    {
        $result = FormHelper::url('website', 'https://example.com');
        
        $this->assertStringContainsString('name="website"', $result);
        $this->assertStringContainsString('type="url"', $result);
        $this->assertStringContainsString('value="https://example.com"', $result);
    }

    /**
     * Tests the week() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::week
     * @return void
     */
    public function testWeek()
    {
        $result = FormHelper::week('project_week', '2024-W12');
        
        $this->assertStringContainsString('name="project_week"', $result);
        $this->assertStringContainsString('type="week"', $result);
        $this->assertStringContainsString('value="2024-W12"', $result);
    }

    /**
     * Tests the hidden() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::hidden
     * @return void
     */
    public function testHidden()
    {
        $result = FormHelper::hidden('csrf_token', 'abc123def456');
        
        $this->assertStringContainsString('name="csrf_token"', $result);
        $this->assertStringContainsString('type="hidden"', $result);
        $this->assertStringContainsString('value="abc123def456"', $result);
    }

    // ========================================
    // Tests for textarea() method
    // ========================================

    /**
     * Tests the textarea() method with basic parameters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::textarea
     * @return void
     */
    public function testTextareaBasic()
    {
        $result = FormHelper::textarea('message', 'Hello, world!');
        
        $this->assertStringContainsString('<textarea', $result);
        $this->assertStringContainsString('name="message"', $result);
        $this->assertStringContainsString('>Hello, world!</textarea>', $result);
    }

    /**
     * Tests the textarea() method with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::textarea
     * @return void
     */
    public function testTextareaWithAttributes()
    {
        $result = FormHelper::textarea('description', 'Product description', [
            'rows' => '5',
            'cols' => '40',
            'placeholder' => 'Enter description...',
            'class' => 'form-control'
        ]);
        
        $this->assertStringContainsString('name="description"', $result);
        $this->assertStringContainsString('rows="5"', $result);
        $this->assertStringContainsString('cols="40"', $result);
        $this->assertStringContainsString('placeholder="Enter description..."', $result);
        $this->assertStringContainsString('class="form-control"', $result);
        $this->assertStringContainsString('>Product description</textarea>', $result);
    }

    /**
     * Tests the textarea() method with HTML escaping.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::textarea
     * @return void
     */
    public function testTextareaWithHtmlEscaping()
    {
        $result = FormHelper::textarea('content', '<script>alert("xss")</script>');
        
        $this->assertStringContainsString('>&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;</textarea>', $result);
        $this->assertStringNotContainsString('<script>', $result);
    }

    /**
     * Tests the textarea() method with null value.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::textarea
     * @return void
     */
    public function testTextareaWithNullValue()
    {
        $result = FormHelper::textarea('notes');
        
        $this->assertStringContainsString('name="notes"', $result);
        $this->assertStringContainsString('></textarea>', $result);
    }

    // ========================================
    // Tests for button methods
    // ========================================

    /**
     * Tests the button() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::button
     * @return void
     */
    public function testButton()
    {
        $result = FormHelper::button('action', 'Click Me', ['class' => 'btn btn-primary']);
        
        $this->assertStringContainsString('<button', $result);
        $this->assertStringContainsString('name="action"', $result);
        $this->assertStringContainsString('type="button"', $result);
        $this->assertStringContainsString('class="btn btn-primary"', $result);
        $this->assertStringContainsString('>Click Me</button>', $result);
    }

    /**
     * Tests the submit() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::submit
     * @return void
     */
    public function testSubmit()
    {
        $result = FormHelper::submit('submit', 'Submit Form', ['id' => 'submit-btn']);
        
        $this->assertStringContainsString('<button', $result);
        $this->assertStringContainsString('name="submit"', $result);
        $this->assertStringContainsString('type="submit"', $result);
        $this->assertStringContainsString('id="submit-btn"', $result);
        $this->assertStringContainsString('>Submit Form</button>', $result);
    }

    /**
     * Tests button methods with null values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::button
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::submit
     * @return void
     */
    public function testButtonsWithNullValues()
    {
        $button = FormHelper::button('btn');
        $this->assertStringContainsString('></button>', $button);
        
        $submit = FormHelper::submit('sub');
        $this->assertStringContainsString('></button>', $submit);
    }

    // ========================================
    // Tests for label() method
    // ========================================

    /**
     * Tests the label() method with basic text.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::label
     * @return void
     */
    public function testLabelBasic()
    {
        $result = FormHelper::label('Username');
        
        $this->assertStringContainsString('<label', $result);
        $this->assertStringContainsString('>Username</label>', $result);
        $this->assertStringNotContainsString('for=', $result);
        $this->assertStringNotContainsString('form=', $result);
    }

    /**
     * Tests the label() method with for attribute.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::label
     * @return void
     */
    public function testLabelWithFor()
    {
        $result = FormHelper::label('Email Address', 'email-field');
        
        $this->assertStringContainsString('for="email-field"', $result);
        $this->assertStringContainsString('>Email Address</label>', $result);
    }

    /**
     * Tests the label() method with form attribute.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::label
     * @return void
     */
    public function testLabelWithForm()
    {
        $result = FormHelper::label('Password', 'pwd-field', 'login-form');
        
        $this->assertStringContainsString('for="pwd-field"', $result);
        $this->assertStringContainsString('form="login-form"', $result);
        $this->assertStringContainsString('>Password</label>', $result);
    }

    /**
     * Tests the label() method with additional attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::label
     * @return void
     */
    public function testLabelWithAttributes()
    {
        $result = FormHelper::label('Required Field', 'field-id', null, [
            'class' => 'control-label required',
            'data-required' => 'true'
        ]);
        
        $this->assertStringContainsString('for="field-id"', $result);
        $this->assertStringContainsString('class="control-label required"', $result);
        $this->assertStringContainsString('data-required="true"', $result);
        $this->assertStringContainsString('>Required Field</label>', $result);
    }

    /**
     * Tests the label() method with HTML escaping.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::label
     * @return void
     */
    public function testLabelWithHtmlEscaping()
    {
        $result = FormHelper::label('Title & Description');
        
        $this->assertStringContainsString('>Title &amp; Description</label>', $result);
        $this->assertStringNotContainsString('Title & Description', $result);
    }

    // ========================================
    // Tests for select methods
    // ========================================

    /**
     * Tests the select() method with basic options.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::select
     * @return void
     */
    public function testSelectBasic()
    {
        $options = [
            'apple' => 'Apple',
            'banana' => 'Banana',
            'orange' => 'Orange'
        ];
        
        $result = FormHelper::select('fruit', $options, 'banana');
        
        $this->assertStringContainsString('<select', $result);
        $this->assertStringContainsString('name="fruit"', $result);
        $this->assertStringContainsString('<option value="apple">Apple</option>', $result);
        $this->assertStringContainsString('<option value="banana" selected="selected">Banana</option>', $result);
        $this->assertStringContainsString('<option value="orange">Orange</option>', $result);
        $this->assertStringContainsString('</select>', $result);
    }

    /**
     * Tests the select() method with optgroups.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::select
     * @return void
     */
    public function testSelectWithOptgroups()
    {
        $options = [
            'Fruits' => [
                'apple' => 'Apple',
                'banana' => 'Banana'
            ],
            'Vegetables' => [
                'carrot' => 'Carrot',
                'lettuce' => 'Lettuce'
            ]
        ];
        
        $result = FormHelper::select('food', $options, 'carrot');
        
        $this->assertStringContainsString('<optgroup label="Fruits">', $result);
        $this->assertStringContainsString('<option value="apple">Apple</option>', $result);
        $this->assertStringContainsString('<option value="banana">Banana</option>', $result);
        $this->assertStringContainsString('</optgroup>', $result);
        
        $this->assertStringContainsString('<optgroup label="Vegetables">', $result);
        $this->assertStringContainsString('<option value="carrot" selected="selected">Carrot</option>', $result);
        $this->assertStringContainsString('<option value="lettuce">Lettuce</option>', $result);
    }

    /**
     * Tests the selectMultiple() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::selectMultiple
     * @return void
     */
    public function testSelectMultiple()
    {
        $options = ['red' => 'Red', 'green' => 'Green', 'blue' => 'Blue'];
        $result = FormHelper::selectMultiple('colors', $options, 'green', ['size' => '3']);
        
        $this->assertStringContainsString('name="colors"', $result);
        $this->assertStringContainsString('multiple="multiple"', $result);
        $this->assertStringContainsString('size="3"', $result);
        $this->assertStringContainsString('<option value="green" selected="selected">Green</option>', $result);
    }

    /**
     * Tests the select() method with attributes.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::select
     * @return void
     */
    public function testSelectWithAttributes()
    {
        $options = ['1' => 'One', '2' => 'Two'];
        $result = FormHelper::select('number', $options, null, [
            'id' => 'number-select',
            'class' => 'form-control',
            'required' => 'required'
        ]);
        
        $this->assertStringContainsString('id="number-select"', $result);
        $this->assertStringContainsString('class="form-control"', $result);
        $this->assertStringContainsString('required="required"', $result);
    }

    // ========================================
    // Tests for option and optgroup methods
    // ========================================

    /**
     * Tests the option() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::option
     * @return void
     */
    public function testOption()
    {
        $result = FormHelper::option('value1', 'Text 1', false);
        $this->assertEquals('<option value="value1">Text 1</option>', $result);
        
        $result = FormHelper::option('value2', 'Text 2', true);
        $this->assertEquals('<option value="value2" selected="selected">Text 2</option>', $result);
    }

    /**
     * Tests the option() method with HTML escaping.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::option
     * @return void
     */
    public function testOptionWithHtmlEscaping()
    {
        $result = FormHelper::option('test', 'Option & Text');
        $this->assertStringContainsString('>Option &amp; Text</option>', $result);
        $this->assertStringNotContainsString('Option & Text', $result);
    }

    /**
     * Tests the optgroup() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::optgroup
     * @return void
     */
    public function testOptgroup()
    {
        $options = '<option value="1">One</option><option value="2">Two</option>';
        $result = FormHelper::optgroup('Numbers', $options, ['class' => 'number-group']);
        
        $this->assertStringContainsString('<optgroup', $result);
        $this->assertStringContainsString('label="Numbers"', $result);
        $this->assertStringContainsString('class="number-group"', $result);
        $this->assertStringContainsString($options, $result);
        $this->assertStringContainsString('</optgroup>', $result);
    }

    // ========================================
    // Tests for checkbox and radio methods
    // ========================================

    /**
     * Tests the checkbox() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::checkbox
     * @return void
     */
    public function testCheckbox()
    {
        $result = FormHelper::checkbox('agree', '1', false);
        
        $this->assertStringContainsString('name="agree"', $result);
        $this->assertStringContainsString('type="checkbox"', $result);
        $this->assertStringContainsString('value="1"', $result);
        $this->assertStringNotContainsString('checked=', $result);
    }

    /**
     * Tests the checkbox() method when checked.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::checkbox
     * @return void
     */
    public function testCheckboxChecked()
    {
        $result = FormHelper::checkbox('newsletter', 'yes', true, ['id' => 'newsletter-cb']);
        
        $this->assertStringContainsString('name="newsletter"', $result);
        $this->assertStringContainsString('value="yes"', $result);
        $this->assertStringContainsString('checked="checked"', $result);
        $this->assertStringContainsString('id="newsletter-cb"', $result);
    }

    /**
     * Tests the radio() method.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::radio
     * @return void
     */
    public function testRadio()
    {
        $result = FormHelper::radio('gender', 'male', false);
        
        $this->assertStringContainsString('name="gender"', $result);
        $this->assertStringContainsString('type="radio"', $result);
        $this->assertStringContainsString('value="male"', $result);
        $this->assertStringNotContainsString('checked=', $result);
    }

    /**
     * Tests the radio() method when checked.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::radio
     * @return void
     */
    public function testRadioChecked()
    {
        $result = FormHelper::radio('size', 'large', true, ['class' => 'size-radio']);
        
        $this->assertStringContainsString('name="size"', $result);
        $this->assertStringContainsString('value="large"', $result);
        $this->assertStringContainsString('checked="checked"', $result);
        $this->assertStringContainsString('class="size-radio"', $result);
    }

    /**
     * Tests checkbox and radio with null values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::checkbox
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::radio
     * @return void
     */
    public function testCheckboxRadioWithNullValues()
    {
        $checkbox = FormHelper::checkbox('check');
        $this->assertStringContainsString('name="check"', $checkbox);
        $this->assertStringContainsString('value=""', $checkbox);
        
        $radio = FormHelper::radio('radio');
        $this->assertStringContainsString('name="radio"', $radio);
        $this->assertStringContainsString('value=""', $radio);
    }

    // ========================================
    // Tests for HTML escaping and security
    // ========================================

    /**
     * Tests HTML escaping in various input types.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::text
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::hidden
     * @return void
     */
    public function testHtmlEscapingInInputs()
    {
        $maliciousValue = '<script>alert("xss")</script>';
        
        $text = FormHelper::text('test', $maliciousValue);
        $this->assertStringContainsString('value="&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;"', $text);
        $this->assertStringNotContainsString('<script>', $text);
        
        $hidden = FormHelper::hidden('token', $maliciousValue);
        $this->assertStringContainsString('value="&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;"', $hidden);
        $this->assertStringNotContainsString('<script>', $hidden);
    }

    /**
     * Tests attribute values with quotes and special characters.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::text
     * @return void
     */
    public function testAttributeEscaping()
    {
        $result = FormHelper::text('field', 'value with "quotes" & entities', [
            'placeholder' => 'Enter "quoted" value',
            'title' => 'Field & Title'
        ]);
        
        $this->assertStringContainsString('value="value with &quot;quotes&quot; &amp; entities"', $result);
        $this->assertStringContainsString('placeholder="Enter &quot;quoted&quot; value"', $result);
        $this->assertStringContainsString('title="Field &amp; Title"', $result);
    }

    // ========================================
    // Tests for edge cases and complex scenarios
    // ========================================

    /**
     * Tests complex form with multiple elements.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper
     * @return void
     */
    public function testComplexFormScenario()
    {
        $form = '';
        
        // Form opening
        $form .= FormHelper::open('/users', 'POST', ['enctype' => 'multipart/form-data']);
        
        // Various inputs
        $form .= FormHelper::text('name', 'John Doe', ['required' => 'required']);
        $form .= FormHelper::email('email', 'john@example.com');
        $form .= FormHelper::password('password');
        $form .= FormHelper::date('birth_date', '1990-01-01');
        $form .= FormHelper::number('age', '30', ['min' => '18', 'max' => '120']);
        
        // Textarea
        $form .= FormHelper::textarea('bio', 'Software developer');
        
        // Select with options
        $countries = ['US' => 'United States', 'CA' => 'Canada', 'UK' => 'United Kingdom'];
        $form .= FormHelper::select('country', $countries, 'US');
        
        // Checkboxes and radios
        $form .= FormHelper::checkbox('newsletter', '1', true);
        $form .= FormHelper::radio('gender', 'male', false);
        $form .= FormHelper::radio('gender', 'female', true);
        
        // Submit button
        $form .= FormHelper::submit('submit', 'Create Account');
        
        // Form closing
        $form .= FormHelper::close();
        
        // Verify form structure
        $this->assertStringContainsString('<form', $form);
        $this->assertStringContainsString('enctype="multipart/form-data"', $form);
        $this->assertStringContainsString('name="name"', $form);
        $this->assertStringContainsString('type="email"', $form);
        $this->assertStringContainsString('type="password"', $form);
        $this->assertStringContainsString('<textarea', $form);
        $this->assertStringContainsString('<select', $form);
        $this->assertStringContainsString('type="checkbox"', $form);
        $this->assertStringContainsString('type="radio"', $form);
        $this->assertStringContainsString('type="submit"', $form);
        $this->assertStringContainsString('</form>', $form);
    }

    /**
     * Tests select with empty options array.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::select
     * @return void
     */
    public function testSelectWithEmptyOptions()
    {
        $result = FormHelper::select('empty', []);
        
        $this->assertStringContainsString('<select', $result);
        $this->assertStringContainsString('name="empty"', $result);
        $this->assertStringContainsString('></select>', $result);
        $this->assertStringNotContainsString('<option', $result);
    }

    /**
     * Tests range input with string values for min/max.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::range
     * @return void
     */
    public function testRangeWithStringValues()
    {
        $result = FormHelper::range('test', '50', '0', '100');
        
        $this->assertStringContainsString('min="0"', $result);
        $this->assertStringContainsString('max="100"', $result);
        $this->assertStringContainsString('value="50"', $result);
    }

    /**
     * Tests various input types with empty string values.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::text
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::email
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::number
     * @return void
     */
    public function testInputsWithEmptyStringValues()
    {
        $text = FormHelper::text('field', '');
        $this->assertStringContainsString('value=""', $text);
        
        $email = FormHelper::email('email', '');
        $this->assertStringContainsString('value=""', $email);
        
        $number = FormHelper::number('num', '');
        $this->assertStringContainsString('value=""', $number);
    }

    /**
     * Tests performance with large option sets.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::select
     * @return void
     */
    public function testSelectPerformanceWithLargeOptionSet()
    {
        $options = [];
        for ($i = 1; $i <= 1000; $i++) {
            $options["option_$i"] = "Option $i";
        }
        
        $result = FormHelper::select('large_select', $options, 'option_500');
        
        $this->assertStringContainsString('<select', $result);
        $this->assertStringContainsString('</select>', $result);
        $this->assertStringContainsString('<option value="option_1">Option 1</option>', $result);
        $this->assertStringContainsString('<option value="option_500" selected="selected">Option 500</option>', $result);
        $this->assertStringContainsString('<option value="option_1000">Option 1000</option>', $result);
    }

    /**
     * Tests form methods with AttributesHelper instances.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::text
     * @covers \AndreasGlaser\Helpers\Html\FormHelper::select
     * @return void
     */
    public function testMethodsWithAttributesHelperInstances()
    {
        $textAttrs = new AttributesHelper(['class' => 'form-control', 'data-test' => 'value']);
        $text = FormHelper::text('name', 'test', $textAttrs);
        
        $this->assertStringContainsString('class="form-control"', $text);
        $this->assertStringContainsString('data-test="value"', $text);
        
        $selectAttrs = new AttributesHelper(['id' => 'country-select', 'required' => 'required']);
        $select = FormHelper::select('country', ['US' => 'United States'], null, $selectAttrs);
        
        $this->assertStringContainsString('id="country-select"', $select);
        $this->assertStringContainsString('required="required"', $select);
    }
} 