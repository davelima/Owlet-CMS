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
 * String treatments
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Extensions
 * @version r1.0.1
 * @license Apache 2.0
 */
class Strings
{

    /**
     * Turns a string into a slug
     *
     * @param string $string            
     * @return string
     */
    public static function Slug($string)
    {
        $in = Array(
            "á",
            "à",
            "â",
            "ã",
            "ä",
            "é",
            "è",
            "ê",
            "ë",
            "í",
            "ì",
            "î",
            "ï",
            "ó",
            "ò",
            "ô",
            "õ",
            "ö",
            "ú",
            "ù",
            "û",
            "ü",
            "ý",
            "ÿ",
            "'",
            '"',
            " - ",
            " ",
            ":",
            "\\",
            "\/",
            "!",
            "?",
            "*",
            "~",
            "#",
            "$",
            "¨",
            "\&"
        );
        $out = Array(
            "a",
            "a",
            "a",
            "a",
            "a",
            "e",
            "e",
            "e",
            "e",
            "i",
            "i",
            "i",
            "i",
            "o",
            "o",
            "o",
            "o",
            "o",
            "u",
            "u",
            "u",
            "u",
            "y",
            "y",
            "-",
            "-",
            "-",
            "-",
            "-",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "e"
        );
        $string = str_replace($in, $out, $string);
        $string = strtolower($string);
        
        return $string;
    }

    /**
     * Generate a randomic string using characters from A to Z and numbers from 0 to 9
     *
     * @param number $length
     *            final length of the string
     * @return string
     */
    public static function randomString($length = 32)
    {
        $letters = range("A", "Z");
        $numbers = range(0, 9);
        $all = array_merge($letters, $numbers);
        $sizeAll = count($all) - 1;
        $i = 0;
        $result = array();
        while ($i < $length) {
            $result[] = $all[rand(0, $sizeAll)];
            $i ++;
        }
        return implode("", $result);
    }

    /**
     * Return the name of a month (1-12)
     *
     * @param integer $monthNumber            
     */
    public static function monthName($monthNumber)
    {
        $months = array(
            null,
            "janeiro",
            "fevereiro",
            "março",
            "abril",
            "maio",
            "junho",
            "julho",
            "agosto",
            "setembro",
            "outubro",
            "novembro",
            "dezembro"
        );
        return $months[$monthNumber];
    }
}