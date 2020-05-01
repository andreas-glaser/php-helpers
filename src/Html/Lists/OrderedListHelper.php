<?php

namespace AndreasGlaser\Helpers\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class OrderedListHelper.
 */
class OrderedListHelper extends BaseListHelper
{
    /**
     * @return string
     */
    public function render(RendererInterface $renderer = null)
    {
        if ($renderer) {
            return $renderer->render($this);
        }

        $html = '<ol' . $this->attributes . '>';

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

        $html .= '</ol>';

        return $html;
    }
}
