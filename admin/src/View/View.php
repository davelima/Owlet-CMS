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
namespace View;

/**
 * View Class
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace View
 * @version r1.0
 * @license Apache 2.0
 */
class View
{

    /**
     * If the view exists, load it, otherwise returns a 404 error HTTP code
     *
     * @param string $view            
     */
    public static function load($view)
    {
        $pathView = __DIR__ . "/../../templates/$view.php";
        if (file_exists($pathView)) {
            require_once ($pathView);
        } else {
            $errorFile = __DIR__."/../../404.php";
            if(file_exists($errorFile)){
                require($errorFile);
            }
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }
}