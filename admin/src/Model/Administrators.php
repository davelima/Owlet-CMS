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
 * Manage the administrators accounts
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @version r1.0.1
 * @license Apache 2.0
 */
class Administrators extends Base
{

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "name" => null,
        "username" => null,
        "email" => null,
        "password" => null,
        "permissions" => null,
        "root" => null,
        "id" => null
    );

    /**
     * Table to save data
     */
    const TABLE = "administrators";

    /**
     * Extension of the Save method
     *
     * @access public
     * @return \Modules\mixed
     * @see Base::Save()
     */
    public function Save()
    {
        $required = array(
            "name" => "Nome",
            "username" => "Login"
        );
        $this->validateData($required);
        parent::Save();
    }

    /**
     * Authenticate a login request by verifying the input
     *
     * @param array $input            
     * @return boolean
     */
    public function Authenticate(array $input)
    {
        $this->killSession();
        $input['username'] = addslashes($input['username']);
        $condition = "username = '{$input['username']}'";
        $user = Data::Select($this, $condition, 1);
        if (isset($user[0]) && password_verify($input['password'], $user[0]->getPassword())) {
            $_SESSION['administrator'] = $user[0];
            return true;
        }
        $this->killSession();
        return false;
    }

    /**
     * Kills the actual session
     */
    public function killSession()
    {
        unset($_SESSION['administrator']);
    }

    /**
     * Verify if an administrator have root permissions
     *
     * @param string $id            
     * @return boolean
     */
    public function isRoot($id = false)
    {
        if (! $id) {
            if ($this->isAuthenticated()) {
                return $_SESSION['administrator']->getRoot();
            }
        } else {
            $info = $this->getById($id);
            return $info->getRoot();
        }
        return false;
    }

    /**
     * Verify if there is an administrator authenticated
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        return (isset($_SESSION['administrator']) && $_SESSION['administrator'] instanceof Administrators);
    }

    /**
     * Extension of the Base::validateData() method
     *
     * @param array $required            
     * @throws \Exception
     * @access protected
     * @return boolean
     */
    protected function validateData(array $required)
    {
        if (! is_null($this->password) && \Extensions\Security::needsRehash($this->password)) {
            $this->password = \Extensions\Security::Hash($this->password);
        }
        
        if ($this->getId()) {
            $info = $this->getById($this->getId());
        }
        
        if (! $this->getId() || ($info && $info->getUserName() != $this->username)) {
            $username = ($this->getId() ? $info->getUserName() : $this->username);
            
            $existent = count($this->getByColumn("username", $username));
            
            if ($existent) {
                throw new \Exception("Este nome de usuário já foi registrado!");
            }
        }
        
        if (is_array($this->permissions)) {
            $this->permissions = json_encode($this->permissions);
        }
        
        if (! isset($this->root)) {
            $this->setRoot(0);
        }
        
        parent::validateData($required);
        return true;
    }
}