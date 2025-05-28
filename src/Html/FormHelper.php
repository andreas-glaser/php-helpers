<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;

/**
 * Class FormHelper
 * 
 * Helper class for generating HTML form elements.
 * Provides methods for creating various form inputs, selects, and other form-related elements.
 * All methods are static and return HTML strings.
 */
class FormHelper
{
    /**
     * Creates an opening form tag
     *
     * @param string|null                                                $action          The form action URL
     * @param string                                                    $method          The form method (GET or POST)
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered form opening tag
     */
    public static function open($action = null, $method = 'GET', $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('action', $action);
        $attributesHelper->set('method', \strtoupper($method));

        return '<form' . $attributesHelper . '>';
    }

    /**
     * Creates a closing form tag
     *
     * @return string The rendered form closing tag
     */
    public static function close(): string
    {
        return '</form>';
    }

    /**
     * Creates a text input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered text input
     */
    public static function text($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'text');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a password input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered password input
     */
    public static function password($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'password');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates an email input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered email input
     */
    public static function email($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'email');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a color input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value (hex color code)
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered color input
     */
    public static function color($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'color');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a date input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value (YYYY-MM-DD)
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered date input
     */
    public static function date($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'date');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a datetime input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered datetime input
     */
    public static function datetime($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'datetime');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a datetime-local input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered datetime-local input
     */
    public static function datetimeLocal($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'datetime-local');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a month input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value (YYYY-MM)
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered month input
     */
    public static function month($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'month');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a number input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered number input
     */
    public static function number($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'number');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a range input field
     *
     * @param string                                                    $name            The input name
     * @param int                                                      $value           The input value
     * @param int                                                      $min             The minimum value
     * @param int                                                      $max             The maximum value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered range input
     */
    public static function range($name, $value, $min, $max, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'range');
        $attributesHelper->set('min', $min);
        $attributesHelper->set('max', $max);
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a search input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered search input
     */
    public static function search($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'search');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a telephone input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered telephone input
     */
    public static function tel($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'tel');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a time input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value (HH:MM)
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered time input
     */
    public static function time($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'time');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a URL input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered URL input
     */
    public static function url($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'url');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a week input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value (YYYY-Www)
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered week input
     */
    public static function week($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'week');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a hidden input field
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered hidden input
     */
    public static function hidden($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'hidden');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a textarea element
     *
     * @param string                                                    $name            The textarea name
     * @param string|null                                              $value           The textarea content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered textarea
     */
    public static function textarea($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);

        return '<textarea' . $attributesHelper . '>' . HtmlHelper::chars($value) . '</textarea>';
    }

    /**
     * Creates a button element
     *
     * @param string                                                    $name            The button name
     * @param string|null                                              $value           The button text
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered button
     */
    public static function button($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'button');

        return '<button' . $attributesHelper . '>' . $value . '</button>';
    }

    /**
     * Creates a submit button element
     *
     * @param string                                                    $name            The button name
     * @param string|null                                              $value           The button text
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered submit button
     */
    public static function submit($name, $value = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'submit');

        return '<button' . $attributesHelper . '>' . $value . '</button>';
    }

    /**
     * Creates a label element
     *
     * @param string                                                    $value           The label text
     * @param string|null                                              $forId           The ID of the element this label is for
     * @param string|null                                              $formId          The ID of the form this label belongs to
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered label
     */
    public static function label($value, $forId = null, $formId = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);

        if ($forId) {
            $attributesHelper->set('for', $forId);
        }

        if ($formId) {
            $attributesHelper->set('form', $formId);
        }

        return '<label' . $attributesHelper . '>' . HtmlHelper::chars($value) . '</label>';
    }

    /**
     * Creates a select element
     *
     * @param string                                                    $name            The select name
     * @param array                                                     $options         Array of options (value => text) or optgroups (label => [value => text])
     * @param string|null                                              $checkedValue    The value of the selected option
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered select element
     */
    public static function select($name, array $options, $checkedValue = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);

        $htmlContent = '';
        foreach ($options as $value => $option) {
            if (\is_array($option)) {
                $optGroupContent = '';
                foreach ($option as $value1 => $option1) {
                    $optGroupContent .= static::option($value1, $option1, $value1 === $checkedValue);
                }
                $htmlContent .= static::optgroup($value, $optGroupContent);
            } else {
                $htmlContent .= static::option($value, $option, $value === $checkedValue);
            }
        }

        return '<select' . $attributesHelper . '>' . $htmlContent . '</select>';
    }

    /**
     * Creates a multiple select element
     *
     * @param string                                                    $name            The select name
     * @param array                                                     $options         Array of options (value => text) or optgroups (label => [value => text])
     * @param string|null                                              $checkedValue    The value of the selected option
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered multiple select element
     */
    public static function selectMultiple($name, array $options, $checkedValue = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('multiple', 'multiple');

        $htmlContent = '';
        foreach ($options as $value => $option) {
            if (\is_array($option)) {
                $optGroupContent = '';
                foreach ($option as $value1 => $option1) {
                    $optGroupContent .= static::option($value1, $option1, $value1 === $checkedValue);
                }
                $htmlContent .= static::optgroup($value, $optGroupContent);
            } else {
                $htmlContent .= static::option($value, $option, $value === $checkedValue);
            }
        }

        return '<select' . $attributesHelper . '>' . $htmlContent . '</select>';
    }

    /**
     * Creates an option element
     *
     * @param string $value    The option value
     * @param string $text     The option text
     * @param bool   $selected Whether this option is selected
     *
     * @return string The rendered option element
     */
    public static function option($value, $text, $selected = false): string
    {
        $attributesHelper = AttributesHelper::f();
        $attributesHelper->set('value', $value);

        if ($selected) {
            $attributesHelper->set('selected', 'selected');
        }

        return '<option' . $attributesHelper . '>' . HtmlHelper::chars($text) . '</option>';
    }

    /**
     * Creates an optgroup element
     *
     * @param string                                                    $label           The optgroup label
     * @param string                                                    $htmlContent     The HTML content (options) for this group
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered optgroup element
     */
    public static function optgroup($label, $htmlContent, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('label', $label);

        return '<optgroup' . $attributesHelper . '>' . $htmlContent . '</optgroup>';
    }

    /**
     * Creates a checkbox input
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param bool                                                      $checked         Whether the checkbox is checked
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered checkbox input
     */
    public static function checkbox($name, $value = null, $checked = false, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'checkbox');
        $attributesHelper->set('value', $value);

        if ($checked) {
            $attributesHelper->set('checked', 'checked');
        }

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * Creates a radio input
     *
     * @param string                                                    $name            The input name
     * @param string|null                                              $value           The input value
     * @param bool                                                      $checked         Whether the radio is checked
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered radio input
     */
    public static function radio($name, $value = null, $checked = false, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'radio');
        $attributesHelper->set('value', $value);

        if ($checked) {
            $attributesHelper->set('checked', 'checked');
        }

        return '<input' . $attributesHelper . ' />';
    }
}
