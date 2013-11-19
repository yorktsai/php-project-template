<?php
namespace York\Kernel\Utils;

class TypeUtils
{
    public static function toBoolean($value)
    {
        if ('N' == strtoupper($value)) {
            return false;
        } elseif ('Y' == strtoupper($value)) {
            return true;
        }

        if ($value) {
            return true;
        }

        return false;
    }

}
