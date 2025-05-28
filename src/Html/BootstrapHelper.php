<?php

namespace AndreasGlaser\Helpers\Html;

use AndreasGlaser\Helpers\HtmlHelper;

/**
 * Class BootstrapHelper
 * 
 * Helper class for generating Bootstrap-specific HTML elements.
 * Provides methods for creating Bootstrap components and elements.
 */
class BootstrapHelper
{
    /**
     * Creates a Bootstrap glyphicon span element
     *
     * @param string                                                         $name            The glyphicon name (without 'glyphicon-' prefix)
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper Additional HTML attributes
     *
     * @return string The rendered glyphicon HTML
     */
    public static function glyphIcon($name, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);

        return HtmlHelper::span('', $attributesHelper
            ->addClass('glyphicon')
            ->addClass('glyphicon-' . $name));
    }
}
