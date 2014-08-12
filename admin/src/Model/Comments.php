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
 * Manage the comments of users on Blog
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @see Blog
 * @version r1.0
 * @license Apache 2.0
 */
class Comments extends Base
{

    /**
     * Table to save data
     */
    const TABLE = "comments";

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "name" => null,
        "body" => null,
        "post" => null,
        "reply" => null
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
            "body" => "Comentário"
        );
        $this->validateData($required);
        $this->setPost($this->getPost()
            ->getId());
        parent::Save();
    }

    /**
     * Return all replies to a determined comment
     *
     * @param number $commentID            
     * @return \Model\Comments
     */
    public function getReplies($commentID)
    {
        return $this->getByColumn("reply", $commentID);
    }

    /**
     * Extension of the __get() method
     *
     * @see \Model\Base::__get()
     */
    public function __get($key)
    {
        if ($key == "post") {
            $blog = new Blog();
            return $blog->getById($this->properties[$key]);
        }
        return parent::__get($key);
    }
}