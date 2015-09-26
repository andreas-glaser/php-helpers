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
     * @param                                              $name
     * @param null                                         $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function text($name, $value = null, AttributesHelper $attributesHelper = null)
    {
        if (!$attributesHelper) {
            $attributesHelper = AttributesHelper::create();
        }

        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'text');
        $attributesHelper->set('value', $value);

        return '<input' . $attributesHelper . ' />';
    }

    /**
     * @param                                              $name
     * @param null                                         $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function textarea($name, $value = null, AttributesHelper $attributesHelper = null)
    {
        if (!$attributesHelper) {
            $attributesHelper = AttributesHelper::create();
        }

        $attributesHelper->set('name', $name);

        return '<textarea' . $attributesHelper . '>' . HtmlHelper::chars($value) . '</textarea>';
    }

    /**
     * @param                                              $name
     * @param null                                         $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function button($name, $value = null, AttributesHelper $attributesHelper = null)
    {
        if (!$attributesHelper) {
            $attributesHelper = AttributesHelper::create();
        }

        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'button');

        return '<button' . $attributesHelper . '>' . $value . '</button>';
    }

    /**
     * @param                                              $name
     * @param null                                         $value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function submit($name, $value = null, AttributesHelper $attributesHelper = null)
    {
        if (!$attributesHelper) {
            $attributesHelper = AttributesHelper::create();
        }

        $attributesHelper->set('name', $name);
        $attributesHelper->set('type', 'submit');

        return '<button' . $attributesHelper . '>' . $value . '</button>';
    }

    /**
     * @author Andreas Glaser
     */
    public static function label()
    {
        // todo
    }

    /**
     * @author Andreas Glaser
     */
    public static function select()
    {
        // todo
    }

    /**
     * @author Andreas Glaser
     */
    public static function checkbox()
    {
        // todo
    }

    /**
     * @author Andreas Glaser
     */
    public static function radio()
    {
        // todo
    }
}