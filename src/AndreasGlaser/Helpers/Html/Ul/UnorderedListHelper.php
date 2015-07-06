<?php

namespace AndreasGlaser\Helpers\Html\Ul;

use AndreasGlaser\Helpers\Html\AttributesHelper;

class UnorderedListHelper
{

    protected $attributes;
    protected $listItems = [];

    public static function create(AttributesHelper $attributes = null)
    {
        return new UnorderedListHelper($attributes);
    }

    public function __construct(AttributesHelper $attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function li($content, AttributesHelper $attributes = null)
    {
        $index = count($this->listItems);
        $this->listItems[$index]['content'] = $content;
        $this->listItems[$index]['attributes'] = $attributes;

        return $this;
    }

    public function render()
    {
        $html = '<ul' . ($this->attributes ? $this->attributes : null) . '>' . PHP_EOL;

        $liCount = count($this->listItems);
        $liIndex = 0;

        foreach ($this->listItems AS $li) {

            /** @var AttributesHelper $attributes */
            $attributes = $li['attributes'] ? $li['attributes'] : AttributesHelper::create();

            if ($liIndex === 0) {
                $attributes->addClass('item-first');
            }

            if ($liIndex === $liCount -1) {
                $attributes->addClass('item-last');
            }

            $attributes->addClass('item-index-' . $liIndex);

            $html .= '<li' . $attributes . '>' . $li['content'] . '</li>' . PHP_EOL;

            $liIndex++;
        }

        $html .= '</ul>' . PHP_EOL;

        return $html;
    }

    public function __toString()
    {
        return $this->render();
    }
}