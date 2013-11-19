<?php
namespace York\Kernel\Test;

require_once 'PHPUnit/Framework/TestCase.php';

abstract class YTestCase extends \PHPUnit_Framework_TestCase
{
    private static $valueCache;

    public static function setValue($key, $value)
    {
        self::$valueCache[$key] = $value;
    }

    public static function getValue($key)
    {
        return self::$valueCache[$key];
    }

    protected function setUp()
    {
        // init value cache
        self::$valueCache = array();
    }
}
