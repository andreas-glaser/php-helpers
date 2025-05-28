<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Html\AttributesHelper;

/**
 * HtmlHelper provides utility methods for generating and manipulating HTML.
 * 
 * This class contains methods for:
 * - HTML encoding and escaping
 * - Generating common HTML elements
 * - Converting text to HTML paragraphs
 * - Working with HTML attributes
 */
class HtmlHelper
{
    /**
     * Converts special characters to HTML entities.
     *
     * @param mixed $value The value to convert
     * @param bool $double_encode Whether to encode existing HTML entities
     *
     * @return string The encoded string
     */
    public static function chars($value, $double_encode = true): string
    {
        return \htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8', $double_encode);
    }

    /**
     * Converts all applicable characters to HTML entities.
     *
     * @param mixed $value The value to convert
     * @param bool $double_encode Whether to encode existing HTML entities
     *
     * @return string The encoded string
     */
    public static function entities($value, $double_encode = true): string
    {
        return \htmlentities((string)$value, ENT_QUOTES, 'UTF-8', $double_encode);
    }

    /**
     * Creates a div element.
     *
     * @param mixed $content The content of the div
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered div element
     */
    public static function div($content, $attributesHelper = null): string
    {
        return '<div' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</div>';
    }

    /**
     * Creates a paragraph element.
     *
     * @param mixed $content The content of the paragraph
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered paragraph element
     */
    public static function p($content, $attributesHelper = null): string
    {
        return '<p' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</p>';
    }

    /**
     * Creates a span element.
     *
     * @param mixed $content The content of the span
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered span element
     */
    public static function span($content, $attributesHelper = null): string
    {
        return '<span' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</span>';
    }

    /**
     * Creates a heading element (h1-h6).
     *
     * @param mixed $content The content of the heading
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered heading element
     */
    public static function h1($content, $attributesHelper = null): string
    {
        return '<h1' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h1>';
    }

    /**
     * Creates a heading element (h1-h6).
     *
     * @param mixed $content The content of the heading
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered heading element
     */
    public static function h2($content, $attributesHelper = null): string
    {
        return '<h2' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h2>';
    }

    /**
     * Creates a heading element (h1-h6).
     *
     * @param mixed $content The content of the heading
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered heading element
     */
    public static function h3($content, $attributesHelper = null): string
    {
        return '<h3' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h3>';
    }

    /**
     * Creates a heading element (h1-h6).
     *
     * @param mixed $content The content of the heading
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered heading element
     */
    public static function h4($content, $attributesHelper = null): string
    {
        return '<h4' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h4>';
    }

    /**
     * Creates a heading element (h1-h6).
     *
     * @param mixed $content The content of the heading
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered heading element
     */
    public static function h5($content, $attributesHelper = null): string
    {
        return '<h5' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h5>';
    }

    /**
     * Creates a heading element (h1-h6).
     *
     * @param mixed $content The content of the heading
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered heading element
     */
    public static function h6($content, $attributesHelper = null): string
    {
        return '<h6' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h6>';
    }

    /**
     * Creates an anchor element.
     *
     * @param string $href The URL for the link
     * @param mixed $content The content of the link
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered anchor element
     */
    public static function a($href, $content, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('href', $href);

        return '<a' . $attributesHelper . ' >' . $content . '</a>';
    }

    /**
     * Creates an image element.
     *
     * @param string $src The source URL of the image
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered image element
     */
    public static function image($src, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('src', $src);

        return '<img' . $attributesHelper . ' />';
    }

    /**
     * Automatically applies paragraph and line break markup to text.
     * 
     * This method is an enhanced version of nl2br that:
     * - Wraps text in paragraph tags
     * - Preserves existing HTML elements
     * - Handles multiple line breaks appropriately
     * - Optionally converts single line breaks to <br> tags
     *
     * @param string $str The text to convert
     * @param bool $br Whether to convert single line breaks to <br> tags
     *
     * @return string The HTML formatted text
     */
    public static function autoParagraph($str, $br = true): string
    {
        // Trim whitespace
        if ('' === ($str = \trim($str))) {
            return '';
        }

        // Standardize newlines
        $str = \str_replace(["\r\n", "\r"], "\n", $str);

        // Trim whitespace on each line
        $str = \preg_replace('~^[ \t]+~m', '', $str);
        $str = \preg_replace('~[ \t]+$~m', '', $str);

        // The following regexes only need to be executed if the string contains html
        if ($html_found = (false !== \strpos($str, '<'))) {
            // Elements that should not be surrounded by p tags
            $no_p = '(?:p|div|h[1-6r]|ul|ol|li|blockquote|d[dlt]|pre|t[dhr]|t(?:able|body|foot|head)|c(?:aption|olgroup)|form|s(?:elect|tyle)|a(?:ddress|rea)|ma(?:p|th))';

            // Put at least two linebreaks before and after $no_p elements
            $str = \preg_replace('~^<' . $no_p . '[^>]*+>~im', "\n$0", $str);
            $str = \preg_replace('~</' . $no_p . '\s*+>$~im', "$0\n", $str);
        }

        // Do the <p> magic!
        $str = '<p>' . \trim($str) . '</p>';
        $str = \preg_replace('~\n{2,}~', "</p>\n\n<p>", $str);

        // The following regexes only need to be executed if the string contains html
        if (false !== $html_found) {
            // Remove p tags around $no_p elements
            $str = \preg_replace('~<p>(?=</?' . $no_p . '[^>]*+>)~i', '', $str);
            $str = \preg_replace('~(</?' . $no_p . '[^>]*+>)</p>~i', '$1', $str);
        }

        // Convert single linebreaks to <br />
        if (true === $br) {
            $str = \preg_replace('~(?<!\n)\n(?!\n)~', "<br />\n", $str);
        }

        return $str;
    }

    /**
     * Converts an array of strings to HTML paragraphs.
     *
     * @param array $paragraphs Array of strings to convert to paragraphs
     *
     * @return string The HTML formatted paragraphs
     */
    public static function arrayToParagraphs($paragraphs): string
    {
        $html = '';

        foreach ($paragraphs as $paragraph) {
            $html .= static::p($paragraph);
        }

        return $html;
    }
}
