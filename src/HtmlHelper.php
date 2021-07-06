<?php

namespace AndreasGlaser\Helpers;

use AndreasGlaser\Helpers\Exceptions\UnexpectedTypeException;
use AndreasGlaser\Helpers\Html\AttributesHelper;

class HtmlHelper
{
    public static function chars(string $value, bool $double_encode = true): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $double_encode);
    }

    public static function entities(string $value, bool $double_encode = true): string
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', $double_encode);
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function div(string $content, $attributesHelper = null): string
    {
        return '<div' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</div>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function p(string $content, $attributesHelper = null): string
    {
        return '<p' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</p>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function span(string $content, $attributesHelper = null): string
    {
        return '<span' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</span>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function h1(string $content, $attributesHelper = null): string
    {
        return '<h1' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h1>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function h2(string $content, $attributesHelper = null): string
    {
        return '<h2' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h2>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function h3(string $content, $attributesHelper = null): string
    {
        return '<h3' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h3>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function h4(string $content, $attributesHelper = null): string
    {
        return '<h4' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h4>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function h5(string $content, $attributesHelper = null): string
    {
        return '<h5' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h5>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function h6(string $content, $attributesHelper = null): string
    {
        return '<h6' . ($attributesHelper ? AttributesHelper::f($attributesHelper) : null) . '>' . $content . '</h6>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function a(string $href, string $content, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('href', $href);

        return '<a' . $attributesHelper . ' >' . $content . '</a>';
    }

    /**
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $attributesHelper
     */
    public static function image($src, $attributesHelper = null): string
    {
        $attributesHelper = AttributesHelper::f($attributesHelper);
        $attributesHelper->set('src', $src);

        return '<img' . $attributesHelper . ' />';
    }

    /**
     * Automatically applies "p" and "br" markup to text.
     * Basically [nl2br](http://php.net/nl2br) on steroids.
     *     echo static::auto_p($text);
     * [!!] This method is not foolproof since it uses regex to parse HTML.
     */
    public static function autoParagraph(string $str, bool $br = true): string
    {
        // Trim whitespace
        if ('' === ($str = trim($str))) {
            return '';
        }

        // Standardize newlines
        $str = str_replace(["\r\n", "\r"], "\n", $str);

        // Trim whitespace on each line
        $str = preg_replace('~^[ \t]+~m', '', $str);
        $str = preg_replace('~[ \t]+$~m', '', $str);

        // The following regexes only need to be executed if the string contains html
        if ($html_found = (false !== strpos($str, '<'))) {
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
        if (false !== $html_found) {
            // Remove p tags around $no_p elements
            $str = preg_replace('~<p>(?=</?' . $no_p . '[^>]*+>)~i', '', $str);
            $str = preg_replace('~(</?' . $no_p . '[^>]*+>)</p>~i', '$1', $str);
        }

        // Convert single linebreaks to <br />
        if (true === $br) {
            $str = preg_replace('~(?<!\n)\n(?!\n)~', "<br />\n", $str);
        }

        return $str;
    }

    public static function arrayToParagraphs(array $paragraphs): string
    {
        $html = '';
        foreach ($paragraphs as $paragraph) {
            if (false === \is_string($paragraph) && false === is_numeric($paragraph)) {
                throw new UnexpectedTypeException($paragraph, 'string or integer');
            }
            $html .= static::p($paragraph) . PHP_EOL;
        }

        return $html;
    }
}
