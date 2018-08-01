<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;

/**
 * Class BootstrapHelper
 *
 * @package AndreasGlaser\Helpers\Html
 */
class BootstrapHelper
{
    /**
     * @param                                                         $name
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     */
    public static function glyphIcon($name, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);

        return HtmlHelper::span('', $attributesHelper
            ->addClass('glyphicon')
            ->addClass('glyphicon-' . $name));
    }
}