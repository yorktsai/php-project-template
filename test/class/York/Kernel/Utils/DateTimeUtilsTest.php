<?php
require_once dirname(__FILE__).'/../../../../../config/TestConfig.inc.php';

use York\Kernel\Utils\DateTimeUtils;
use York\Kernel\Test\YTestCase;

class DateTimeUtilsTest extends YTestCase
{
    public function testGetNowDateTime()
    {
        $now = DateTimeUtils::getNowDateTime();
        DateTimeUtils::setNowDateTime(new DateTime('2000-01-01'));
        $fakeNow = DateTimeUtils::getNowDateTime();
        $this->assertTrue($now != $fakeNow);
        DateTimeUtils::setNowDateTime(null);
    }

    public function testTestReset()
    {
        $fakeNow = new DateTime('2000-01-01');
        $this->assertTrue($fakeNow != DateTimeUtils::getNowDateTime());
    }

}
