<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Html\Ul\UnorderedListHelper;

/**
 * Class HtmlHelper
 *
 * @package Helpers
 *
 * @author  Andreas Glaser
 */
class HtmlHelper
{
    public static function chars($value, $double_encode = true)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'utf-8', $double_encode);
    }

    public static function entities($value, $double_encode = true)
    {
        return htmlentities((string)$value, ENT_QUOTES, 'utf-8', $double_encode);
    }

    public static function div($content, Html\AttributesHelper $attributes = null)
    {
        return '<div' . ($attributes ? $attributes : null) . '>' . $content . '</div>';
    }

    public static function p($content, Html\AttributesHelper $attributes = null)
    {
        return '<p' . ($attributes ? $attributes : null) . '>' . $content . '</p>';
    }

    public static function span($content, Html\AttributesHelper $attributes = null)
    {
        return '<span' . ($attributes ? $attributes : null) . '>' . $content . '</span>';
    }

    public static function h1($content, Html\AttributesHelper $attributes = null)
    {
        return '<h1' . ($attributes ? $attributes : null) . '>' . $content . '</h1>';
    }

    public static function h2($content, Html\AttributesHelper $attributes = null)
    {
        return '<h2' . ($attributes ? $attributes : null) . '>' . $content . '</h2>';
    }

    public static function h3($content, Html\AttributesHelper $attributes = null)
    {
        return '<h3' . ($attributes ? $attributes : null) . '>' . $content . '</h3>';
    }

    public static function h4($content, Html\AttributesHelper $attributes = null)
    {
        return '<h4' . ($attributes ? $attributes : null) . '>' . $content . '</h4>';
    }

    public static function h5($content, Html\AttributesHelper $attributes = null)
    {
        return '<h5' . ($attributes ? $attributes : null) . '>' . $content . '</h5>';
    }

    public static function h6($content, Html\AttributesHelper $attributes = null)
    {
        return '<h6' . ($attributes ? $attributes : null) . '>' . $content . '</h6>';
    }

    public static function image($src, Html\AttributesHelper $attributes = null)
    {
        return '<img src="' . $src . '"' . ($attributes ? $attributes : null) . '/>';
    }

    /**
     * Automatically applies "p" and "br" markup to text.
     * Basically [nl2br](http://php.net/nl2br) on steroids.
     *
     *     echo static::auto_p($text);
     *
     * [!!] This method is not foolproof since it uses regex to parse HTML.
     *
     * @param   string  $str subject
     * @param   boolean $br  convert single linebreaks to <br />
     *
     * @return  string
     */
    public static function autoParagraph($str, $br = true)
    {
        // Trim whitespace
        if (($str = trim($str)) === '') {
            return '';
        }

        // Standardize newlines
        $str = str_replace(["\r\n", "\r"], "\n", $str);

        // Trim whitespace on each line
        $str = preg_replace('~^[ \t]+~m', '', $str);
        $str = preg_replace('~[ \t]+$~m', '', $str);

        // The following regexes only need to be executed if the string contains html
        if ($html_found = (strpos($str, '<') !== false)) {
            // Elements that should not be surrounded by p tags
            $no_p = '(?:p|div|h[1-6r]|ul|ol|li|blockquote|d[dlt]|pre|t[dhr]|t(?:able|body|foot|head)|c(?:aption|olgroup)|form|s(?:elect|tyle)|a(?:ddress|rea)|ma(?:p|th))';

            // Put at least two linebreaks before and after $no_p elements
            $str = preg_replace('~^<' . $no_p . '[^>]*+>~im', "\n$0", $str);
            $str = preg_replace('~</' . $no_p . '\s*+>$~im', "$0\n", $str);
        }

        // Do the <p> magic!
        $str = '<p>' . trim($str) . '</p>';
        $str = preg_replace('~\n{2,}~', "</p>\n\n<p>", $str);

        // The following regexes only need to be executed if the string contains html
        if ($html_found !== false) {
            // Remove p tags around $no_p elements
            $str = preg_replace('~<p>(?=</?' . $no_p . '[^>]*+>)~i', '', $str);
            $str = preg_replace('~(</?' . $no_p . '[^>]*+>)</p>~i', '$1', $str);
        }

        // Convert single linebreaks to <br />
        if ($br === true) {
            $str = preg_replace('~(?<!\n)\n(?!\n)~', "<br />\n", $str);
        }

        return $str;
    }

    /**
     * @param $paragraphs
     *
     * @return string
     *
     * @author Andreas Glaser
     */
    public static function arrayToParagraphs($paragraphs)
    {
        $html = '';

        foreach ($paragraphs AS $paragraph) {
            $html .= static::p($paragraph);
        }

        return $html;
    }
}
