<?php
declare(strict_types=1);

namespace GuzabaPlatform\Cms\Tests\Controllers;

use Guzaba2\Http\Method;
use GuzabaPlatform\Cms\Models\Page;
use GuzabaPlatform\Platform\Application\BaseTestController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TestPage
 * @package GuzabaPlatform\Cms\Tests\Controllers
 *
 * These tests are testing not just the Page functionality but also core Guzaba2 framework functionality.
 */
class TestPage extends BaseTestController
{
    protected const CONFIG_DEFAULTS = [
        'routes' => [
            '/tests/cms/page/1' => [
                Method::HTTP_POST => [self::class, 'test_page_1'],
            ],
            '/tests/cms/page/2' => [
                Method::HTTP_POST => [self::class, 'test_page_1'],
            ],
        ]
    ];

    protected const CONFIG_RUNTIME = [];

    /**
     * Tests is the property modification preserved even if there is a second instance of the same record.
     * @return ResponseInterface
     * @throws \Azonmedia\Exceptions\InvalidArgumentException
     * @throws \Guzaba2\Base\Exceptions\InvalidArgumentException
     * @throws \Guzaba2\Base\Exceptions\LogicException
     * @throws \Guzaba2\Base\Exceptions\RunTimeException
     * @throws \Guzaba2\Coroutine\Exceptions\ContextDestroyedException
     * @throws \Guzaba2\Kernel\Exceptions\ConfigurationException
     * @throws \ReflectionException
     */
    public function test_page_1(): ResponseInterface
    {
        $new_content = 'new content '.time();

        $Page = self::get_existing_page();
        $Page->page_content = $new_content;

        $Page2 = new Page($Page->get_id());
        if ($Page2->page_content === $new_content && $Page->get_modified_properties_names() === $Page2->get_modified_properties_names()) {
            return self::get_structured_ok_response( ['response' => 'OK'] );
        } else {
            return self::get_structured_ok_response( ['response' => 'fail'] );
        }
    }

    public function test_page_2(): ResponseInterface
    {
        $new_content = 'new content '.time();

        $Page = self::get_existing_page();

        $Page2 = new Page($Page->get_id());
        $Page2->page_content = $new_content;
        if ($Page->page_content === $new_content && $Page->get_modified_properties_names() === $Page2->get_modified_properties_names()) {
            return self::get_structured_ok_response( ['response' => 'OK'] );
        } else {
            return self::get_structured_ok_response( ['response' => 'fail'] );
        }
    }

    /**
     * Returns a page. There need to be at least one page existing.
     * @return Page
     * @throws \Azonmedia\Exceptions\InvalidArgumentException
     * @throws \Guzaba2\Base\Exceptions\InvalidArgumentException
     * @throws \Guzaba2\Base\Exceptions\LogicException
     * @throws \Guzaba2\Base\Exceptions\RunTimeException
     * @throws \Guzaba2\Coroutine\Exceptions\ContextDestroyedException
     * @throws \Guzaba2\Kernel\Exceptions\ConfigurationException
     * @throws \ReflectionException
     */
    private static function get_existing_page(): Page
    {
        $pages = Page::get_data_by( [], $offset = 0, $limit = 1);//get any page

        $Page = new Page($pages[0]['page_id']);
        return $Page;
    }
}