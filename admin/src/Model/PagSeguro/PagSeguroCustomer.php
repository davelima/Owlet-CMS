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
namespace Model\PagSeguro;

use \Lib\Data;

/**
 * Concentrate all informations about PagSeguro's customers
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model\PagSeguro
 * @uses \Lib\Data
 * @version r1.1
 * @license Apache 2.0
 */
class PagSeguroCustomer extends \Model\Base
{

    /**
     * All possible properties
     *
     * @var array
     */
    public $properties = array(
        "name" => null,
        "email" => null,
        "areacode" => null,
        "phone" => null,
        "cep" => null,
        "address" => null,
        "number" => null,
        "addresscomplement" => null,
        "neighborhood" => null,
        "city" => null,
        "state" => null,
        "country" => null
    );
}