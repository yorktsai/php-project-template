<?php
namespace York\Kernel\Utils;

class FileUtils
{
    const TMP_ROOT = '/tmp';

    public static function getExtension($filename)
    {
        $tokens = explode('.', $filename);

        return $tokens[count($tokens) - 1];
    }

    /**
     * Create a temp folder
     *
     * @return string folder path
     */
    public static function createTempFolder()
    {
        $path = null;
        while (is_null($path)) {
            $folderName = 'york_tmp_'.StringUtils::randomAlphaNumericString(8);
            $path = implode('/', array(self::TMP_ROOT, $folderName));

            if (file_exists($path)) {
                $path = null;
            } else {
                mkdir($path, 0777, true);
            }
        }

        if (!file_exists($path)) {
            throw new Exception('Cannot create temp folder.');
        }

        return $path;
    }

    /**
     * Create a temp file
     *
     * @param  string $folderPath
     * @param  string $extension
     * @return string file path
     */
    public static function createTempFile($folderPath, $extension)
    {
        // parameters
        if (StringUtils::endsWith($folderPath, '/')) {
            $folderPath = substr($folderPath, 0, strlen($folderPath)-1);
        }

        $path = null;
        while (is_null($path)) {
            $filename = StringUtils::randomAlphaNumericString(8).'.'.$extension;
            $path = implode('/', array($folderPath, $filename));

            if (file_exists($path)) {
                $path = null;
            } else {
                touch($path);
            }
        }

        if (!file_exists($path)) {
            throw new Exception('Cannot create temp file.');
        }

        return $path;
    }

    /**
     * Delete a directory recursively. If the path is too short (< 5 charactors, do nothing)
     *
     * @param  string  $directory dir path
     * @param  boolean $empty
     * @return boolean success or not
     */
    public static function deleteDirRecursively($directory, $empty=false)
    {
        // if the path has a slash at the end we remove it here
        if (substr($directory,-1) == '/') {
            $directory = substr($directory,0,-1);
        }

        // if the dir is too short, do nothing since its too dangerous
        if (strlen($directory) < 6) {
            return false;
        }

        // already deleted
        if (!file_exists($directory)) {
            return true;
        }

        // if is not a directory or not readable...
        if (!is_dir($directory) || !is_readable($directory)) {
            return false;
        }

        // we open the directory
        $handle = opendir($directory);

        // and scan through the items inside
        while (false !== ($item = readdir($handle))) {
            // if the filepointer is not the current directory
            // or the parent directory
            if ($item != '.' && $item != '..') {
                // we build the new path to delete
                $path = $directory.'/'.$item;

                // if the new path is a directory
                if (is_dir($path)) {
                    // we call this function with the new path
                    if (!self::deleteDirRecursively($path)) {
                        return false;
                    }
                // if the new path is a file
                } else {
                    // we remove the file
                    unlink($path);
                }
            }
        }
        // close the directory
        closedir($handle);

        // if the option to empty is not set to true
        if (false === $empty) {
            // try to delete the now empty directory
            if (!rmdir($directory)) {
                // return false if not possible
                return false;
            }
        }
        // return success
        return true;
    }
}
