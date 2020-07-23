<?php
declare(strict_types=1);

use Codeception\Util\HttpCode;

class PageCest
{
    public function _before(ApiTester $I): void
    {
    }

    // tests
    public function test_page_1(ApiTester $I): void
    {
        $I->sendPOST('/tests/cms/page/1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function test_page_2(ApiTester $I): void
    {
        $I->sendPOST('/tests/cms/page/2');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function test_page_alias(ApiTester $I): void
    {
        $I->sendGET('/tests/cms/page/alias');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

}