<?php
namespace York\Kernel\Utils;

use York\Kernel\Utils\StringUtils;

class CollectionUtils
{
    public static function isVarDumpEquals($var1, $var2)
    {
        ob_start();
        var_dump($var1);
        $content1 = ob_get_contents();
        ob_end_clean();

        ob_start();
        var_dump($var2);
        $content2 = ob_get_contents();
        ob_end_clean();

        return $content1 == $content2;
    }

    /**
     * REF: http://php.net/manual/en/function.explode.php
     *
     * Explode and trim each token.
     *
     * @param  string  $delimiter
     * @param  string  $str
     * @param  boolean $skipEmpty
     * @return array   tokens
     */
    public static function explodeTrim($delimiter, $str, $skipEmpty=true)
    {
        if (!is_string($delimiter)) {
            throw new EZParameterException('delimiter should be string.');
        }
        $tmpTokens = explode($delimiter, $str);
        $tokens = array();
        foreach ($tmpTokens as $token) {
            $token = trim($token);
            if ($skipEmpty && empty($token)) {
                continue;
            }
            $tokens[] = $token;
        }

        return $tokens;
    }

    public static function setArrayValuesByColumns(&$target, &$input, $columns=null)
    {
        if (!is_array($input)) {
            return;
        }
        if (is_null($columns)) {
            $columns = array_keys($input);
        }
        foreach ($columns as $column) {
            if (isset($input[$column])) {
                $target[$column] = $input[$column];
            }
        }
    }

    public static function keepArrayValuesByColumns(&$target, $columns)
    {
        if (!is_array($target)) {
            return;
        }
        $toDelete = array_diff(array_keys($target), $columns);
        foreach ($toDelete as $key) {
            unset($target[$key]);
        }
    }

    public static function safeUnset(&$arr, $key)
    {
        if (isset($arr[$key])) {
            unset($arr[$key]);
        }
    }

    public static function unsetEmptyElements(&$arr)
    {
        $keys = array_keys($arr);
        foreach ($keys as $key) {
            if (empty($arr[$key])) {
                unset($arr[$key]);
            }
        }
    }

    public static function unsetNullElements(&$arr)
    {
        $keys = array_keys($arr);
        foreach ($keys as $key) {
            if (is_null($arr[$key])) {
                unset($arr[$key]);
            }
        }
    }

    public static function unsetZeroLengthElements(&$arr)
    {
        $keys = array_keys($arr);
        foreach ($keys as $key) {
            if (strlen($arr[$key]) <= 0) {
                unset($arr[$key]);
            }
        }
    }

    public static function cloneArray($arr)
    {
        return unserialize(serialize($arr));
    }

    /**
     * mkPaths make nested associative array according to specified path
     *
     * for example,
     *      mkPaths(array(), array("layer1", "layer2", "layer3"))
     *
     * would return :
     *      array("layer1" =>
     *          array("layer2" =>
     *              array("layer3" => array()
     *              )
     *          )
     *      )
     *
     * @param $arr the array we are going to make path into
     * @param $path array the keys used in nested associative structure.
     *          $path[0] is at depth 0, $path[1] is at depath 1, and so on
     *
     * @return array a nested associative array with the specified path
     */
    public static function mkPaths(&$arr, $path)
    {
        $current = &$arr;
        foreach ($path as $name) {
            if (!isset($current[$name])) {
                $current[$name] = array();
            }
            $current = &$current[$name];
        }
    }

    /**
     * hasPath check if array has specified array structure (path)
     *
     * @param array         $arr  the array we are going to make path into
     * @param array(string) $path array the keys used in nested associative structure.
     *          $path[0] is at depth 0, $path[1] is at depath 1, and so on
     *
     * @return boolean return if array has specified array structure (path);
     *          return false otherwise
     */
    public static function hasPath($arr, $path)
    {
        $current = $arr;
        foreach ($path as $name) {
            if (!isset($current[$name])) {
                return false;
            }
            $current = $current[$name];
        }

        return true;
    }

    /**
     * setToPath save data to specified array structure
     *
     * @param $arr the array we are going to make path into
     * @param $path array the keys used in nested associative structure.
     *          $path[0] is at depth 0, $path[1] is at depath 1, and so on
     *
     * @param $data the data to be saved
     * @return void
     */
    public static function setToPath(&$arr, $path, $data)
    {
        if (! self::hasPath($arr, $path)) {
            self::mkPaths($arr, $path);
        }

        // remove and save last item
        $last_path_item = array_pop($path);

        // walk into array
        $current = &$arr;
        foreach ($path as $path_item) {
            $current = &$current[$path_item];
        }

        $current[$last_path_item] = $data;
    }

    /**
     * getFromPath get data from specified array structure
     *
     * @param $arr the array we are going to make path into
     * @param $path array the keys used in nested associative structure.
     *          $path[0] is at depth 0, $path[1] is at depath 1, and so on
     *
     * @return mixed, the data stored on the specified path; return false if path does not exist
     */
    public static function getFromPath(&$arr, $path)
    {
        if (! self::hasPath($arr, $path)) {
            return false;
        }

        // remove and save last item
        $last_path_item = array_pop($path);

        // walk into array
        $current = &$arr;
        foreach ($path as $path_item) {
            $current = &$current[$path_item];
        }

        return $current[$last_path_item];
    }

    public static function safeCopyElement(&$dstArray, &$srcArray, $dstElementName, $srcElementName=null)
    {
        // default value
        if (is_null($srcElementName)) {
            $srcElementName = $dstElementName;
        }
        // data validation
        if (!is_array($dstArray) || !is_array($srcArray)) {
            return;
        }
        if (!isset($srcArray[$srcElementName])) {
            return;
        }
        // copy
        $dstArray[$dstElementName] = $srcArray[$srcElementName];
    }

    /**
     * duplicate column values are overwritten
     */
    public static function indexByColumn($rows, $column)
    {
        $rt = array();
        foreach ($rows as $row) {
            if (isset($row[$column])) {
                $rt[$row[$column]] = $row;
            }
        }

        return $rt;
    }
}
