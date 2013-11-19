<?php
namespace York\Kernel\Utils;

class DateTimeUtils
{
    private static $nowDateTime = null;

    public static function composeDateTime($dateStr, $timeStr)
    {
        return new \DateTime($dateStr.' '.$timeStr);
    }

    public static function getTime($datetime)
    {
        return $datetime->format('H:i:s');
    }

    public static function getMinuteTime($datetime)
    {
        return $datetime->format('H:i');
    }

    /**
     * Please use this function carefully. This will permanently change the current date time in API calls.
     * For unit-test purpose, please call DateTimeUtils::setNowDateTime(null) after the test.
     */
    public static function setNowDateTime($datetime)
    {
        self::$nowDateTime = $datetime;
    }

    public static function getNowDateTime()
    {
        if (!is_null(self::$nowDateTime)) {
            return (clone self::$nowDateTime);
        }

        return new \DateTime();
    }
}
