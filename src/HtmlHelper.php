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

    /**
     * Creates a strong (bold) element.
     *
     * @param mixed $content The content to make bold
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered strong element
     */
    public static function strong($content, $attributesHelper = null): string
    {
        return '<strong' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</strong>';
    }

    /**
     * Creates an em (emphasis/italic) element.
     *
     * @param mixed $content The content to emphasize
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered em element
     */
    public static function em($content, $attributesHelper = null): string
    {
        return '<em' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</em>';
    }

    /**
     * Creates a code element.
     *
     * @param mixed $content The code content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered code element
     */
    public static function code($content, $attributesHelper = null): string
    {
        return '<code' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</code>';
    }

    /**
     * Creates a pre element.
     *
     * @param mixed $content The preformatted content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered pre element
     */
    public static function pre($content, $attributesHelper = null): string
    {
        return '<pre' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</pre>';
    }

    /**
     * Creates a blockquote element.
     *
     * @param mixed $content The quote content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered blockquote element
     */
    public static function blockquote($content, $attributesHelper = null): string
    {
        return '<blockquote' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</blockquote>';
    }

    /**
     * Creates a cite element.
     *
     * @param mixed $content The citation content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered cite element
     */
    public static function cite($content, $attributesHelper = null): string
    {
        return '<cite' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</cite>';
    }

    /**
     * Creates a mark element.
     *
     * @param mixed $content The content to highlight
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered mark element
     */
    public static function mark($content, $attributesHelper = null): string
    {
        return '<mark' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</mark>';
    }

    /**
     * Creates a time element.
     *
     * @param mixed $content The time content
     * @param string|null $datetime The machine-readable datetime
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered time element
     */
    public static function time($content, $datetime = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        if ($datetime !== null) {
            $attributesHelper->set('datetime', $datetime);
        }
        return '<time' . $attributesHelper . '>' . $content . '</time>';
    }

    /**
     * Creates a small element.
     *
     * @param mixed $content The content to make smaller
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered small element
     */
    public static function small($content, $attributesHelper = null): string
    {
        return '<small' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</small>';
    }

    /**
     * Creates a sub element.
     *
     * @param mixed $content The subscript content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered sub element
     */
    public static function sub($content, $attributesHelper = null): string
    {
        return '<sub' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</sub>';
    }

    /**
     * Creates a sup element.
     *
     * @param mixed $content The superscript content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered sup element
     */
    public static function sup($content, $attributesHelper = null): string
    {
        return '<sup' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</sup>';
    }

    /**
     * Creates an abbr element.
     *
     * @param mixed $content The abbreviated content
     * @param string|null $title The full form of the abbreviation
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered abbr element
     */
    public static function abbr($content, $title = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        if ($title !== null) {
            $attributesHelper->set('title', $title);
        }
        return '<abbr' . $attributesHelper . '>' . $content . '</abbr>';
    }

    /**
     * Creates an article element.
     *
     * @param mixed $content The article content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered article element
     */
    public static function article($content, $attributesHelper = null): string
    {
        return '<article' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</article>';
    }

    /**
     * Creates a section element.
     *
     * @param mixed $content The section content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered section element
     */
    public static function section($content, $attributesHelper = null): string
    {
        return '<section' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</section>';
    }

    /**
     * Creates a nav element.
     *
     * @param mixed $content The navigation content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered nav element
     */
    public static function nav($content, $attributesHelper = null): string
    {
        return '<nav' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</nav>';
    }

    /**
     * Creates an aside element.
     *
     * @param mixed $content The aside content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered aside element
     */
    public static function aside($content, $attributesHelper = null): string
    {
        return '<aside' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</aside>';
    }

    /**
     * Creates a header element.
     *
     * @param mixed $content The header content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered header element
     */
    public static function header($content, $attributesHelper = null): string
    {
        return '<header' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</header>';
    }

    /**
     * Creates a footer element.
     *
     * @param mixed $content The footer content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered footer element
     */
    public static function footer($content, $attributesHelper = null): string
    {
        return '<footer' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</footer>';
    }

    /**
     * Creates a main element.
     *
     * @param mixed $content The main content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered main element
     */
    public static function main($content, $attributesHelper = null): string
    {
        return '<main' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</main>';
    }

    /**
     * Creates a figure element.
     *
     * @param mixed $content The figure content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered figure element
     */
    public static function figure($content, $attributesHelper = null): string
    {
        return '<figure' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</figure>';
    }

    /**
     * Creates a figcaption element.
     *
     * @param mixed $content The figcaption content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered figcaption element
     */
    public static function figcaption($content, $attributesHelper = null): string
    {
        return '<figcaption' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</figcaption>';
    }

    /**
     * Creates a details element.
     *
     * @param mixed $content The details content
     * @param bool $open Whether the details should be open by default
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered details element
     */
    public static function details($content, $open = false, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        if ($open) {
            $attributesHelper->set('open', 'open');
        }
        return '<details' . $attributesHelper . '>' . $content . '</details>';
    }

    /**
     * Creates a summary element.
     *
     * @param mixed $content The summary content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered summary element
     */
    public static function summary($content, $attributesHelper = null): string
    {
        return '<summary' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</summary>';
    }

    /**
     * Creates a dialog element.
     *
     * @param mixed $content The dialog content
     * @param bool $open Whether the dialog should be open
     * @param bool $modal Whether the dialog should be modal
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered dialog element
     */
    public static function dialog($content, $open = false, $modal = false, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        if ($open) {
            $attributesHelper->set('open', 'open');
        }
        if ($modal) {
            $attributesHelper->set('modal', 'modal');
        }
        return '<dialog' . $attributesHelper . '>' . $content . '</dialog>';
    }

    /**
     * Creates a meter element.
     *
     * @param mixed $content The meter content/label
     * @param float $value The current value
     * @param float|null $min The minimum value
     * @param float|null $max The maximum value
     * @param float|null $low The low value threshold
     * @param float|null $high The high value threshold
     * @param float|null $optimum The optimum value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered meter element
     */
    public static function meter($content, $value, $min = null, $max = null, $low = null, $high = null, $optimum = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('value', $value);
        if ($min !== null) $attributesHelper->set('min', $min);
        if ($max !== null) $attributesHelper->set('max', $max);
        if ($low !== null) $attributesHelper->set('low', $low);
        if ($high !== null) $attributesHelper->set('high', $high);
        if ($optimum !== null) $attributesHelper->set('optimum', $optimum);
        return '<meter' . $attributesHelper . '>' . $content . '</meter>';
    }

    /**
     * Creates a progress element.
     *
     * @param mixed $content The progress content/label
     * @param float|null $value The current value
     * @param float|null $max The maximum value
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper HTML attributes
     *
     * @return string The rendered progress element
     */
    public static function progress($content, $value = null, $max = null, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        if ($value !== null) $attributesHelper->set('value', $value);
        if ($max !== null) $attributesHelper->set('max', $max);
        return '<progress' . $attributesHelper . '>' . $content . '</progress>';
    }
}
