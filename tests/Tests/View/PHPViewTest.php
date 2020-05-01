<?php

namespace AndreasGlaser\Helpers\Tests\View;

use AndreasGlaser\Helpers\HtmlHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;
use AndreasGlaser\Helpers\View\PHPView;

/**
 * Class PHPViewTest.
 */
class PHPViewTest extends BaseTest
{
    public function test()
    {
        PHPView::setGlobal('name', 'PHPView');

        $view = new PHPView(__DIR__ . DIRECTORY_SEPARATOR . 'view.html.php');
        $view->set('link', HtmlHelper::a('/test', 'Test Url'));
        $view->set('rating', 5);

        self::assertEquals('<p>PHPView</p>' . PHP_EOL . '<p><a href="/test" >Test Url</a> (Rating: 5)</p>', $view->render());
    }
}
