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
 * BlogViews module
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @version r1.0
 * @license Apache 2.0
 */
class BlogViews extends Base
{

    /**
     * Table to save data
     */
    const TABLE = "blogviews";

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "post" => null,
        "ip" => null,
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
            "post" => "Publicação",
            "ip" => "IP"
        );
        $this->validateData($required);
        parent::Save();
    }

    /**
     * Return a post total view count
     *
     * @param $initDate \DateTime            
     * @param $finalDate \DateTime            
     * @throws \Exception
     * @return number
     */
    public function getTotalViews(\DateTime $initDate = null, \DateTime $finalDate = null)
    {
        if (! $this->post || ! $this->post instanceof Blog) {
            throw new \Exception("É necessário definir um post!");
        }
        
        $and = "";
        
        if ($initDate) {
            $initDate = $initDate->format('Y-m-d H:i:s');
            $and .= " timestamp >= '$initDate'";
        }
        
        if ($finalDate) {
            $finalDate = $finalDate->format('Y-m-d H:i:s');
            $and .= " timestamp <= '$initDate'";
        }
        
        $query = \Lib\Data::customQuery("SELECT COUNT(id) AS total FROM $this WHERE post = '" . $this->getPost()->getId() . "'$and");
        $count = $query->fetch(\PDO::FETCH_ASSOC);
        return (int) $count['total'];
    }

    /**
     * Extension of the validateData method
     *
     * @see \Model\Base::validateData()
     */
    protected function validateData(array $required)
    {
        $blog = new Blog();
        if (! $this->getPost()) {
            throw new \Exception("Publicação inválida");
        }
        
        if (! $blog->getById($this->getPost()
            ->getId())) {
            throw new \Exception("Publicação inválida");
        }
        
        $this->setPost($this->getPost()
            ->getId());
        
        $this->setIp($_SERVER['REMOTE_ADDR']);
        parent::validateData($required);
    }
}