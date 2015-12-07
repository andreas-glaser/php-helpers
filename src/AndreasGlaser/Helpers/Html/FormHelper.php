<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;

/**
 * Class FormHelper
 *
 * @package AndreasGlaser\Helpers\Html
 * @author  Andreas Glaser
 */
class FormHelper
{
    /**
     * @param null                                                    $action
     * @param string                                                  $method
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function open($action = null, $method = 'GET', $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('action', $action);
        $attributesHelper->set('method', strtoupper($method));

        return '<form' . $attributesHelper . '>';
    }

    /**
     * @return string
     * @author Andreas Glaser
     */
    public static function close()
    {
        return '</form>';
    }

    /**
     * @param                                                         $name
     * @param null                                                    $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function text($name, $value = null, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'text');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * @param                                                         $name
     * @param null                                                    $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function textarea($name, $value = null, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);

        return '<textarea' . $attributesHelper . '>' . HtmlHelper::chars($value) . '</textarea>';
    }

    /**
     * @param                                                         $name
     * @param null                                                    $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function button($name, $value = null, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'button');

        return '<button' . $attributesHelper . '>' . $value . '</button>';
    }

    /**
     * @param                                                         $name
     * @param null                                                    $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function submit($name, $value = null, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'submit');

        return '<button' . $attributesHelper . '>' . $value . '</button>';
    }

    /**
     * @param                                                         $value
     * @param null                                                    $forId
     * @param null                                                    $formId
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function label($value, $forId = null, $formId = null, $attributesHelper = null)
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
     * @param       $name
     * @param array $options
     * @param null  $checkedValue
     * @param null  $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function select($name, array $options, $checkedValue = null, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);

        $htmlContent = '';
        foreach ($options AS $value => $option) {
            if (is_array($option)) {
                $optGroupContent = '';
                foreach ($option AS $value1 => $option1) {
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
     * @param       $name
     * @param array $options
     * @param null  $checkedValue
     * @param null  $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function selectMultiple($name, array $options, $checkedValue = null, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('name', $name);
        $attributesHelper->set('multiple', 'multiple');

        $htmlContent = '';
        foreach ($options AS $value => $option) {
            if (is_array($option)) {
                $optGroupContent = '';
                foreach ($option AS $value1 => $option1) {
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
     * @param            $value
     * @param            $text
     * @param bool|false $checked
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function option($value, $text, $checked = false)
    {
        $attributesHelper = AttributesHelper::f();
        $attributesHelper->set('value', $value);

        if ($checked) {
            $attributesHelper->set('checked', 'checked');
        }

        return '<option' . $attributesHelper . '>' . HtmlHelper::chars($text) . '</option>';
    }

    /**
     * @param      $label
     * @param      $htmlContent
     * @param null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function optgroup($label, $htmlContent, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('label', $label);

        return '<optgroup' . $attributesHelper . '>' . $htmlContent . '</optgroup>';
    }

    /**
     * @param                                                         $name
     * @param null                                                    $value
     * @param bool                                                    $checked
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function checkbox($name, $value = null, $checked = false, $attributesHelper = null)
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
     * @param                                                         $name
     * @param null                                                    $value
     * @param bool                                                    $checked
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function radio($name, $value = null, $checked = false, $attributesHelper = null)
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