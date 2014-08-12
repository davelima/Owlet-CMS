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
 * Show dismissable notifications compatible with bootstrap framework
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Extensions
 * @version r1.0
 * @license Apache 2.0
 */
class Messages
{

    /**
     * The structure of the alert
     *
     * @staticvar string
     */
    public static $structure = "<div class=\"alert alert-%s\" id=\"result\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> %s</div>";

    /**
     * Return the message markup
     *
     * @param string $type
     *            warning|danger|success|info|default
     * @param string $message
     *            the message to display
     * @return string
     */
    public static function Message($type, $message)
    {
        return sprintf(self::$structure, $type, $message);
    }
}