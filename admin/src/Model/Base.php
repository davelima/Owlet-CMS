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
 * Base methods
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @uses \Lib\Data, \Extensions\Security
 * @license Apache 2.0
 * @version r1.0
 * @abstract
 *
 */
abstract class Base
{
    use \Extensions\Security;

    /**
     * Database instance
     *
     * @staticvar Data
     */
    protected static $db;

    /**
     * Returns the TABLE constant of the class
     *
     * @return string
     */
    public function __toString()
    {
        return static::TABLE;
    }

    /**
     * Set a variable in $this->properties
     *
     * @param string $key            
     * @param mixed $value            
     * @return void
     */
    public function __set($key, $value)
    {
        $this->properties[$key] = $value;
    }

    /**
     * Get a variable from $this->properties
     *
     * @param string $key            
     */
    public function __get($key)
    {
        if (isset($this->properties[$key])) {
            if ($key == "timestamp") {
                return new \DateTime($this->properties[$key]);
            }
            return $this->properties[$key];
        }
    }

    /**
     * The isset() method
     *
     * @param string $key            
     */
    public function __isset($key)
    {
        return isset($this->properties[$key]);
    }

    /**
     * The unset() method
     *
     * @param string $key            
     */
    public function __unset($key)
    {
        unset($this->properties[$key]);
    }

    /**
     * Return all properties of the class
     *
     * @return array mixed
     */
    public function getData()
    {
        return $this->properties;
    }

    /**
     * Dinamic setter and getter
     *
     * @param string $method            
     * @param string $params            
     */
    public function __call($method, $params)
    {
        $prefix = substr($method, 0, 3); // get|set
        $property = strtolower(substr($method, 3));
        switch ($prefix) {
            case "set":
                if (array_key_exists($property, $this->properties)) {
                    $this->$property = $params[0];
                }
                break;
            case "get":
                if (array_key_exists($property, $this->properties)) {
                    return $this->$property;
                }
                break;
        }
    }

    /**
     * Save a register
     *
     * @uses Data::Save
     * @return mixed
     */
    public function Save()
    {
        return Data::Save($this);
    }

    /**
     * Delete an register (irreversible)
     *
     * @return mixed
     */
    public function Remove()
    {
        return Data::Delete($this);
    }

    /**
     * Return all registers
     *
     * @param $orderBy string
     *            Must be the name of a column to order by
     * @return multitype:mixed,array,boolean
     */
    public function getAll($orderBy = "id")
    {
        return Data::Select($this, false, false, $orderBy);
    }

    /**
     * Return registers that satisfies the params
     *
     * @param string $condition            
     * @param string $orderBy            
     * @param string $limit            
     * @return multitype:mixed,array,boolean
     */
    public function get($condition = false, $orderBy = "id", $limit = false)
    {
        return Data::Select($this, $condition, $limit, $orderBy);
    }

    /**
     * Return a single register (get by ID)
     *
     * @param integer $id            
     * @throws \Exception
     * @return self
     */
    public function getById($id = false)
    {
        $id = ($id ? $id : $this->getId());
        $id = intval($id);
        if (! $id) {
            throw new \Exception("É necessário definir um ID");
        }
        $result = Data::Select($this, "id=$id", 1);
        return (isset($result[0]) ? $result[0] : $this);
    }

    /**
     * Return a single register (get by $column)
     *
     * @param string $column            
     * @param string $value            
     * @return self
     */
    public function getByColumn($column, $value)
    {
        $result = Data::Select($this, "$column='$value'", 1);
        return (isset($result) ? $result : $this);
    }

    /**
     * Return an CSV string with table data
     *
     * @return string
     */
    public function getStringCSV()
    {
        $data = $this->getAll();
        $columns = $this->properties;
        $csv = "";
        $csv .= implode(array_keys($this->getData()), ";");
        $csv .= "\n";
        foreach ($data as $item) {
            $csv .= implode($item->getData(), ";");
            $csv .= "\n";
        }
        return $csv;
    }

    /**
     * Verify if all required properties are ok to start a Save command
     *
     * @param array $required            
     * @throws \Exception
     * @return boolean
     */
    protected function validateData(array $required)
    {
        foreach ($required as $property => $value) {
            if (! $this->$property) {
                throw new \Exception("Preencha o campo $value!");
            }
            if ($property == "email") {
                if (! filter_var($this->$property, \FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception("Informe um e-mail válido!");
                }
            }
        }
    }
}