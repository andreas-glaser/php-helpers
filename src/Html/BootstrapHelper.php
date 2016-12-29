<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;

/**
 * Class BootstrapHelper
 *
 * @package AndreasGlaser\Helpers\Html
 * @author  Andreas Glaser
 */
class BootstrapHelper
{
    /**
     * @param                                              $name
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     *
     * @return string
     * @author Andreas Glaser
     */
    public static function glyphIcon($name, $attributesHelper = null)
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);

        return HtmlHelper::span('', $attributesHelper
            ->addClass('glyphicon')
            ->addClass('glyphicon-' . $name));
    }
}