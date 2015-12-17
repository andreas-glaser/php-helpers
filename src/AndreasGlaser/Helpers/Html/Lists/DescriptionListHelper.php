<?php

namespace AndreasGlaser\Helpers\Html\Lists;

use AndreasGlaser\Helpers\Html\AttributesHelper;
use AndreasGlaser\Helpers\Interfaces\RendererInterface;

/**
 * Class DescriptionListHelper
 *
 * @package AndreasGlaser\Helpers\Html\Lists
 * @author  Andreas Glaser
 */
class DescriptionListHelper extends BaseListHelper
{
    /**
     * @param                                                         $term
     * @param                                                         $content
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $termAttributes
     * @param \AndreasGlaser\Helpers\Html\AttributesHelper|array|null $contentAttributes
     *
     * @return $this
     * @author Andreas Glaser
     */
    public function addItem($term, $content, $termAttributes = null, $contentAttributes = null)
    {
        $index = count($this->items);
        $this->items[$index]['term'] = $content;
        $this->items[$index]['content'] = $content;
        $this->items[$index]['termAttributes'] = AttributesHelper::f($termAttributes);
        $this->items[$index]['contentAttributes'] = AttributesHelper::f($contentAttributes);

        return $this;
    }

    /**
     * @param \AndreasGlaser\Helpers\Interfaces\RendererInterface|null $renderer
     *
     * @return string
     * @author Andreas Glaser
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