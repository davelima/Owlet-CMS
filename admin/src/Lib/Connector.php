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
namespace Lib;

/**
 * Provides a singleton instance of a PDO Connection
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @version r1.0
 * @namespace Lib
 * @version r1.0
 * @license Apache 2.0
 */
class Connector extends \Model\Base
{

    /**
     * PDO Instance
     *
     * @staticvar \PDO
     */
    public static $instance;

    /**
     * Connection properties
     *
     * @var array
     */
    public $properties = Array(
        "dsn" => null,
        "user" => null,
        "password" => null,
        "options" => Array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        )
    );

    /**
     * Return the PDO instance
     *
     * @param string $dbms            
     * @param string $database            
     * @param string $host            
     * @param string $user            
     * @param string $password            
     * @static
     *
     * @return \PDO
     */
    public static function getInstance($dbms, $database, $host, $user, $password)
    {
        if (! self::$instance) {
            self::$instance = new Connector($dbms, $database, $host, $user, $password);
            self::$instance->Connect();
        }
        return self::$instance;
    }

    /**
     * Create a connection using PDO
     *
     * @return void
     */
    public function Connect()
    {
        self::$instance = new \PDO($this->dsn, $this->user, $this->password, $this->options);
    }

    /**
     * Generate the connection parameters
     *
     * @param string $dbms            
     * @param string $database            
     * @param string $host            
     * @param string $user            
     * @param string $password            
     */
    private function __construct($dbms, $database, $host, $user, $password)
    {
        $this->dsn = $teste = "$dbms:host=$host;dbname=$database";
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Private the __clone method to avoid instantiation
     */
    private function __clone()
    {}
}