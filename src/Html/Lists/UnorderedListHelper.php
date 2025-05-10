<?php

namespace AndreasGlaser\Helpers\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * UnorderedListHelper provides a helper for generating HTML unordered lists (<ul>).
 *
 * This class allows you to:
 * - Add items to the unordered list
 * - Render the list as HTML
 *
 * Inherits common list functionality from BaseListHelper.
 */
class UnorderedListHelper extends BaseListHelper
{
    /**
     * Renders the unordered list as HTML.
     *
     * @param RendererInterface|null $renderer Optional custom renderer
     * @return string The rendered HTML <ul> element
     */
    public function render(RendererInterface $renderer = null)
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $html = '<ul' . $this->attributes . '>';

        $itemCount = \count($this->items);
        $itemIndex = 0;

        foreach ($this->items as $item) {

            /** @var AttributesHelper $attributes */
            $attributes = $item['attributes'];

            if (0 === $itemIndex) {
                $attributes->addClass('item-first');
            }

            if ($itemIndex === $itemCount - 1) {
                $attributes->addClass('item-last');
            }

            $attributes->addClass('item-index-' . $itemIndex);

            $html .= '<li' . $attributes . '>' . $item['content'] . '</li>';

            ++$itemIndex;
        }

        $html .= '</ul>';

        return $html;
    }
}
