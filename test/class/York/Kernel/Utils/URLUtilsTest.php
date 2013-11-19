<?php
require_once dirname(__FILE__).'/../../../../../config/TestConfig.inc.php';

use York\Kernel\Utils\URLUtils;
use York\Kernel\Test\YTestCase;

class URLUtilsTest extends YTestCase
{
    public function testArrayToParams()
    {
        $paramsStr = URLUtils::arrayToParams(array(
            'a' => '1',
            '2' => 'b',
        ));
        $this->assertEquals('a=1&2=b', $paramsStr);
    }

    public function test_appendURLParameter()
    {
        // append only
        $url = 'http://www.google.com/test.php';
        $parameters = array(
            'a' => '1',
            '2' => 'b',
        );

        $this->assertEquals('http://www.google.com/test.php?a=1&2=b', URLUtils::appendURLParameter($url, $parameters));

        $url = 'http://www.google.com/test.php?c=3';
        $this->assertEquals('http://www.google.com/test.php?c=3&a=1&2=b', URLUtils::appendURLParameter($url, $parameters));

        // overwrite
        $parameters = array(
            'a' => '1',
            '2' => 'b',
            'c' => '5',
        );
        $url = 'http://www.google.com/test.php?c=3';
        $this->assertEquals('http://www.google.com/test.php?c=5&a=1&2=b', URLUtils::appendURLParameter($url, $parameters));
        $this->assertEquals('http://www.google.com/test.php?c=3&a=1&2=b', URLUtils::appendURLParameter($url, $parameters, array(
            'overwrite' => false,
        )));

        // invalid
        $url = 'http://www.google.com/test.php?xxx';
        $this->assertEquals('http://www.google.com/test.php?a=1&2=b&c=5', URLUtils::appendURLParameter($url, $parameters));
        $this->assertEquals('http://www.google.com/test.php?a=1&2=b&c=5', URLUtils::appendURLParameter($url, $parameters, array(
            'overwrite' => false,
        )));

        // encoding
        $url = 'http://www.google.com/test.php?c=foo%20bar%40baz';
        $this->assertEquals('http://www.google.com/test.php?c=5&a=1&2=b', URLUtils::appendURLParameter($url, $parameters));
        $this->assertEquals('http://www.google.com/test.php?c=foo+bar%40baz&a=1&2=b', URLUtils::appendURLParameter($url, $parameters, array(
            'overwrite' => false,
        )));
    }
}
