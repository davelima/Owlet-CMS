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
 * Gravatar retriever implementation
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Extensions
 * @version r1.0
 * @license Apache 2.0
 */
class Gravatar
{

    /**
     * Return the Gravatar of an email
     *
     * @param string $email            
     * @param integer $size            
     * @return string|boolean
     */
    public static function Retrieve($email, $size = 80)
    {
        if (filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            $hash = md5(strtolower(trim($email)));
            $url = "http://www.gravatar.com/avatar/" . $hash . "?s=$size";
            return $url;
        }
        return false;
    }
}