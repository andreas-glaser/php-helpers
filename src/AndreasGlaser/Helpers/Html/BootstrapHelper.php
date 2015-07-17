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
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper $attributesHelper
     * @return string
     * @author Andreas Glaser
     */
    public static function glyphIcon($name, AttributesHelper $attributesHelper = null)
    {
        if (!$attributesHelper) {
            $attributesHelper = AttributesHelper::create();
        }

        return HtmlHelper::span('', $attributesHelper
            ->addClass('glyphicon')
            ->addClass('glyphicon-' . $name));
    }
}