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

        return '<label' . $attributesHelper . '>' . HtmlHelper::chars($value) . '<label>';
    }

    /**
     * @author Andreas Glaser
     */
    public static function select()
    {
        // todo
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