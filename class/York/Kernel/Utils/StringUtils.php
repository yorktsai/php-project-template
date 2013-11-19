<?php
namespace York\Kernel\Utils;

use York\Kernel\Utils\URLUtils;

class StringUtils
{
    public static function randomAlphaNumericString($length, $exclude=array())
    {
        $chars = explode(',','a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9');
        $numChars = count($chars);
        $random='';
        for ($i=0; $i<$length;$i++) {
            $char = $chars[mt_rand(0,$numChars-1)];
            while (in_array($char, $exclude)) {
                $char = $chars[mt_rand(0,$numChars-1)];
            }
            $random .= $char;
        }

        return $random;
    }

    public static function randomHumanReadableString($length)
    {
        return StringUtils::randomAlphaNumericString($length, array(
            '1', 'l',
            'c', 'C',
            'I',
            's', 'S',
            '0', 'O', 'o',
            'v', 'V',
            'w', 'W',
            'x', 'X'
        ));
    }

    public static function randomNumericString($length)
    {
        $chars = explode(',','0,1,2,3,4,5,6,7,8,9');
        $numChars = count($chars);
        $random='';
        for ($i=0; $i<$length;$i++) {
            $char = $chars[mt_rand(0,$numChars-1)];
            $random .= $char;
        }

        return $random;
    }

    public static function startsWith($haystack, $needle)
    {
        $length = min(strlen($needle), strlen($haystack));

        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = min(strlen($needle), strlen($haystack));
        $start  = $length * -1; //negative

        return (substr($haystack, $start) === $needle);
    }

    /**
     * @deprecated
     * Use URLUtils::appendURLParameter instead.
     */
    public static function appendURLParameter($url, $parameters)
    {
        if (false !== strpos('?', $url)) {
            $url .= '&';
            // FIXME: re-encode existed parameters
        } else {
            $url .= '?';
        }
        $paramParts = array();
        foreach ($parameters as $name => $value) {
            $paramParts[] = $name.'='.urlencode($value);
        }
        $url .= implode('&', $paramParts);

        return $url;
    }

    public static function mbTruncate($str, $length)
    {
        if (mb_strlen($str, 'UTF-8') > $length) {
            return mb_substr($str, 0, $length, 'UTF-8'). " ...";
        }

        return $str;
    }

    public static function mbTrim($string)
    {
        $string = preg_replace("/(^\s+)|(\s+$)/us", "", $string);

        return $string;
    }

    /**
     * Camelizes a string.
     *
     * @param string $id A string to camelize
     *
     * @return string The camelized string
     */
    public static function camelize($id)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) { return ('.' === $match[1] ? '_' : '').strtoupper($match[2]); }, $id);
    }
}
