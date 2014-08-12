<?php
/**
 ************************************************************************
Copyright [2014] [David Lima]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
************************************************************************
*/
namespace Extensions;

/**
 * Manage file streams
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @version dev 1.0
 * @namespace Extensions
 * @license Apache 2.0
 */
class Files
{

    /**
     * The file location
     *
     * @staticvar string
     */
    public static $file;

    /**
     * Extensions of self::$file
     *
     * @staticvar string
     */
    public static $extension;

    /**
     * MIME Type of self::$file
     *
     * @staticvar string
     */
    public static $mimeType = "text/plain";

    /**
     * Open a file from $_FILES array
     *
     * @param array $fileInput            
     */
    public static function openFromInput($fileInput)
    {
        self::$file = $fileInput['tmp_name'];
        self::$extension = self::getExtension($fileInput['name']);
    }

    /**
     * Return the extension of a file
     *
     * @param string $filename            
     * @return string
     */
    public static function getExtension($filename)
    {
        return substr($filename, strrpos($filename, ".") + 1);
    }

    /**
     * Write a temp file and send it to user download
     *
     * @param string $string            
     */
    public static function writeAndExport($string, array $options = array())
    {
        if (isset($options['mimeType'])) {
            self::$mimeType = $options['mimeType'];
        }
        
        if (isset($options['extension'])) {
            self::$extension = $options['extension'];
        }
        
        header("Content-Type: " . self::$mimeType);
        
        $filename = uniqid("download-") . self::$extension;
        
        header("Content-Disposition: attachment; filename=$filename");
        
        echo $string;
    }

    /**
     * Save self::$file on specified location
     *
     * @param string $dir
     *            Directory to save file
     * @param string $filename
     *            Name of the file (without extension)
     * @throws \Exception
     * @return string
     */
    public static function save($dir, $filename)
    {
        $filename = $filename . "." . self::$extension;
        if (copy(self::$file, $dir . "/" . $filename)) {
            return $filename;
        }
        throw new \Exception("Ocorreu um erro ao realizar o upload do seu arquivo. Tente novamente em alguns minutos!");
    }
}