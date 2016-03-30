<?php

namespace AndreasGlaser\Helpers\Tests\Html\Table;

use AndreasGlaser\Helpers\Html\Table\Cell;
use AndreasGlaser\Helpers\Html\Table\Row;
use AndreasGlaser\Helpers\Html\Table\TableHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * Class TableHelperTest
 *
 * @package AndreasGlaser\Helpers\Tests\Html\Table
 * @author  Andreas Glaser
 */
class TableHelperTest extends BaseTest
{
    /**
     * @throws \Exception
     * @author Andreas Glaser
     */
    public function test()
    {
        $tableHelper = new TableHelper();
        $tableHelper->getAttributes()->addData('tomato', 123);

        $tableHelper
            ->addHeadRow(
                new Row(
                    [
                        Cell::f('Headline 1', ['class' => 'something']),
                        new Cell('Headline 2'),
                        new Cell('Headline 3'),
                        new Cell('Headline 4'),
                        Cell::f('Headline 4')->setColspan(2)->setScope('col')
                    ]
                )
            )
            ->addBodyRow(
                new Row(
                    [
                        new Cell('Content 1'),
                        new Cell('Content 2'),
                        new Cell('Content 3'),
                        new Cell('Content 4'),
                        new Cell('Content 5')
                    ]
                )
            )
            ->addBodyRow(
                new Row(
                    [
                        new Cell('Content 6'),
                        new Cell('Content 7'),
                        new Cell('Content 8'),
                        new Cell('Content 9'),
                        new Cell('Content 0')
                    ],
                    ['style' => 'background-color:red;']
                )
            );

        $this->assertEquals('<table data-tomato="123"><thead><tr><td class="something">Headline 1</td><td>Headline 2</td><td>Headline 3</td><td>Headline 4</td><td colspan="2" scope="col">Headline 4</td></tr></thead><tbody><tr><td>Content 1</td><td>Content 2</td><td>Content 3</td><td>Content 4</td><td>Content 5</td></tr><tr style="background-color:red;"><td>Content 6</td><td>Content 7</td><td>Content 8</td><td>Content 9</td><td>Content 0</td></tr></tbody></table>', $tableHelper->render());
    }
}