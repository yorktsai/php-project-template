<?php
namespace York\Kernel\Utils;

class URLUtils
{
    public static function arrayToParams($arr)
    {
        $params = array();
        foreach ($arr as $key => $value) {
            $params[] = $key.'='.urlencode($value);
        }

        return implode('&', $params);
    }

    public static function arrayToPathParams($arr)
    {
        $pathArr = array_map('rawurlencode', $arr);

        return implode('/', $pathArr);
    }

    public static function paramStrToArray($paramStr)
    {
        $paramStr = html_entity_decode($paramStr);
        $queryParts = explode('&', $paramStr);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            if (count($item) > 1) {
                $params[$item[0]] = rawurldecode($item[1]);
            }
        }

        return $params;
    }

    /**
     * Append parameters to the given url.
     * Configs:
     * <ul>
     * <li>overwrite: if the parameter is already there, should we overwrite it. (default: true)</li>
     * </ul>
     *
     * @param  string $url
     * @param  array  $parameters
     * @param  array  $config
     * @return string the appended url.
     */
    public static function appendURLParameter($url, $parameters, $config=array())
    {
        // parameters
        $isOverwrite = true;
        if (isset($config['overwrite']) && $config['overwrite'] == false) {
            $isOverwrite = false;
        }

        // base url
        $parseUrl = parse_url($url);
        $urlTokens = explode('?', $url);
        $baseUrl = $urlTokens[0];

        if (!isset($parseUrl['path'])) {
            $baseUrl .= '/';
        }

        // parameters
        if (!empty($parseUrl['query'])) {
            $origParams = self::paramStrToArray($parseUrl['query']);
            foreach ($parameters as $key => $value) {
                if (isset($origParams[$key]) && !$isOverwrite) {
                    continue;
                }
                $origParams[$key] = $value;
            }
            $parameters = $origParams;
        }

        if (count($parameters) > 0) {
            $baseUrl .= '?';
        }

        $baseUrl .= self::arrayToParams($parameters);

        return $baseUrl;
    }
}
