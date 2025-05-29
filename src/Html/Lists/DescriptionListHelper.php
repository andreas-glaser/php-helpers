<?php

namespace AndreasGlaser\Helpers\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\FactoryInterface;
use AndreasGlaser\Helpers\Interfaces\RenderableInterface;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * DescriptionListHelper provides a helper for generating HTML description lists (<dl>).
 *
 * This class allows you to:
 * - Add term/description pairs with custom attributes
 * - Render the list as HTML
 * - Use a factory method for instantiation
 */
class DescriptionListHelper implements FactoryInterface, RenderableInterface
{
    /**
     * @var \AndreasGlaser\Helpers\Html\AttributesHelper HTML attributes for the <dl> element
     */
    protected $attributes;

    /**
     * @var array List of term/description pairs and their attributes
     */
    protected $items = [];

    /**
     * Factory method to create a new DescriptionListHelper instance.
     *
     * @param AttributesHelper|array|null $attributes HTML attributes for the <dl> element
     *
     * @return \AndreasGlaser\Helpers\Html\Lists\DescriptionListHelper A new instance
     */
    public static function f($attributes = null): self
    {
        return new DescriptionListHelper($attributes);
    }

    /**
     * DescriptionListHelper constructor.
     *
     * @param AttributesHelper|array|null $attributes HTML attributes for the <dl> element
     */
    public function __construct($attributes = null)
    {
        $this->attributes = AttributesHelper::f($attributes);
    }

    /**
     * Adds a term/description pair to the list.
     *
     * @param string $term The term (dt)
     * @param string $content The description (dd)
     * @param AttributesHelper|array|null $termAttributes HTML attributes for the term
     * @param AttributesHelper|array|null $contentAttributes HTML attributes for the description
     *
     * @return $this For method chaining
     */
    public function addItem($term, $content, $termAttributes = null, $contentAttributes = null):self
    {
        $index = \count($this->items);
        $this->items[$index]['term'] = $term;
        $this->items[$index]['content'] = $content;
        $this->items[$index]['termAttributes'] = AttributesHelper::f($termAttributes);
        $this->items[$index]['contentAttributes'] = AttributesHelper::f($contentAttributes);

        return $this;
    }

    /**
     * Renders the description list as HTML.
     *
     * @param RendererInterface|null $renderer Optional custom renderer
     * @return string The rendered HTML <dl> element
     */
    public function render(RendererInterface $renderer = null): string
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $html = '<dl' . $this->attributes . '>';

        $itemCount = \count($this->items);
        $itemIndex = 0;

        foreach ($this->items as $item) {

            /** @var AttributesHelper $termAttributes */
            $termAttributes = $item['termAttributes'];
            /** @var AttributesHelper $contentAttributes */
            $contentAttributes = $item['contentAttributes'];

            if (0 === $itemIndex) {
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

            ++$itemIndex;
        }

        $html .= '</dl>';

        return $html;
    }
}
