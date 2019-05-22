<?php

namespace AndreasGlaser\Helpers\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class DescriptionListHelper
 *
 * @package AndreasGlaser\Helpers\Html\Lists
 */
class DescriptionListHelper implements FactoryInterface, RenderableInterface
{

    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @param null|AttributesHelper|array $attributes
     *
     * @return \AndreasGlaser\Helpers\Html\Lists\DescriptionListHelper
     */
    public static function f($attributes = null)
    {
        return new DescriptionListHelper($attributes);
    }

    /**
     * DescriptionListHelper constructor.
     *
     * @param null|AttributesHelper|array $attributes
     */
    public function __construct($attributes = null)
    {
        $this->attributes = AttributesHelper::f($attributes);

        return $this;
    }

    /**
     * @param string $term
     * @param string $content
     * @param null   $termAttributes
     * @param null   $contentAttributes
     *
     * @return $this
     */
    public function addItem($term, $content, $termAttributes = null, $contentAttributes = null)
    {
        $index = count($this->items);
        $this->items[$index]['term'] = $term;
        $this->items[$index]['content'] = $content;
        $this->items[$index]['termAttributes'] = AttributesHelper::f($termAttributes);
        $this->items[$index]['contentAttributes'] = AttributesHelper::f($contentAttributes);

        return $this;
    }

    /**
     * @param \AndreasGlaser\Helpers\Interfaces\RendererInterface|null $renderer
     *
     * @return string
     */
    public function render(RendererInterface $renderer = null)
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $html = '<dl' . $this->attributes . '>';

        $itemCount = count($this->items);
        $itemIndex = 0;

        foreach ($this->items AS $item) {

            /** @var AttributesHelper $termAttributes */
            $termAttributes = $item['termAttributes'];
            /** @var AttributesHelper $contentAttributes */
            $contentAttributes = $item['contentAttributes'];

            if ($itemIndex === 0) {
                $termAttributes->addClass('item-first');
                $contentAttributes->addClass('item-first');
            }

            if ($itemIndex === $itemCount - 1) {
                $termAttributes->addClass('item-last');
                $contentAttributes->addClass('item-last');
            }

            $termAttributes->addClass('item-index-' . $itemIndex);
            $contentAttributes->addClass('item-index-' . $itemIndex);

            $html .= '<dt' . $termAttributes . '>' . $item['term'] . '</dt>';
            $html .= '<dd' . $contentAttributes . '>' . $item['content'] . '</dd>';

            $itemIndex++;
        }

        $html .= '</dl>';

        return $html;
    }
}