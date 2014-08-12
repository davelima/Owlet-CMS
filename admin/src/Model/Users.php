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
namespace Model;

use \Lib\Data;

/**
 * Manage user accounts
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @version r1.0
 * @license Apache 2.0
 */
class Users extends Base
{

    /**
     * Table to save data
     */
    const TABLE = "users";

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "name" => null,
        "email" => null,
        "password" => null,
        "address" => null,
        "number" => null,
        "addresscomplement" => null,
        "neighborhood" => null,
        "cep" => null,
        "city" => null,
        "state" => null,
        "phone" => null,
        "id" => null
    );

    /**
     * Extension of the Save method
     *
     * @see \Model\Base::Save()
     */
    public function Save()
    {
        $required = array(
            "name" => "Nome",
            "email" => "E-mail",
            "password" => "Senha"
        );
        $this->validateData($required);
        parent::Save();
    }

    /**
     * Extension of the validateData method
     *
     * @see \Model\Base::validateData()
     */
    protected function validateData(array $required)
    {
        parent::validateData($required);
        
        if (! is_null($this->password) && \Extensions\Security::needsRehash($this->password)) {
            $this->password = \Extensions\Security::Hash($this->password);
        }
        
        if (! $this->getID()) {
            $exists = $this->getByColumn("email", $this->email);
            if (isset($exists[0])) {
                throw new \Exception("Já existe um usuário cadastrado com este e-mail!");
            }
        }
    }
}