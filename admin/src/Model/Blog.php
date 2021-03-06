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
 * Blog module
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @version r1.0.5
 * @license Apache 2.0
 */
class Blog extends Base
{

    /**
     * Table do save data
     */
    const TABLE = "blog";

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "title" => null,
        "preview" => null,
        "body" => null,
        "slug" => null,
        "head" => null,
        "tags" => null,
        "category" => null,
        "visible" => null,
        "timestamp" => null
    );

    /**
     * Extension of the Save method
     *
     * @see \Model\Base::Save()
     */
    public function Save()
    {
        $required = array(
            "title" => "Título",
            "body" => "Conteúdo"
        );
        $this->setSlug(\Extensions\Strings::Slug($this->title));
        $this->validateData($required);
        $config = \Extensions\Config::get();
        $config = $config->blog;
        parent::Save();
        $sendNotification = (boolean) $config->sendNotificationToMailing->__toString();
        if ($sendNotification) {
            $mailing = new Mailing();
            $mailing = $mailing->getByColumn("status", true);
            $mailer = new \Extensions\Mailer();
            $mailer->subject = "Nova publicação de {$config->blogName}";
            $mailer->message = "<h1>{$this->getTitle()}</h1><hr>" . ($this->getPreview() ? $this->getPreview() : $this->getBody());
            $mailer->showUnsubscribeLink = true;
            foreach ($mailing as $email) {
                $mailer->recipient = array(
                    "name" => $email->getEmail(),
                    "email" => $email->getEmail()
                );
                $mailer->Send();
            }
        }
    }

    /**
     * Implementation of getAll() method
     *
     * @param string $orderBy            
     * @param boolean $showDisabled            
     * @see \Model\Base::getAll()
     */
    public function getAll($orderBy = "id", $showDisabled = false)
    {
        $where = ($showDisabled ? "" : "visible");
        return Data::Select($this, $where, false, $orderBy);
    }

    /**
     * Return posts that satisfies the searched term
     *
     * @param string $term            
     * @return multitype:\Model\mixed,array,boolean
     */
    public function Search($term)
    {
        $slug = \Extensions\Strings::Slug($term);
        $term = filter_var($term, FILTER_SANITIZE_STRING);
        $where = "title LIKE '" . $term . "' OR tags LIKE '%" . $slug . "%'";
        return $this->get($where, "timestamp DESC, id", false);
    }

    /**
     * Extension of validateData method
     *
     * @param array $required            
     * @see \Model\Base::validateData()
     */
    protected function validateData(array $required)
    {
        if (is_array($this->getTags())) {
            $tags = new Tags();
            foreach ($this->getTags() as $tag) {
                if (! $tags->getByColumn("title", $tag)) {
                    $tags->setTitle($tag);
                    $tags->Save();
                }
            }
            $this->setTags(implode(",", $this->getTags()));
        }
        parent::validateData($required);
    }

    /**
     * Get blog posts and return in XML (RSS) format
     *
     * @param integer $limit
     *            Limit of posts to return
     * @return mixed
     */
    public function getRSS($limit = 10)
    {
        $base = new \SimpleXMLElement("<rss></rss>");
        $base->addAttribute("version", "2.0");
        $base->addAttribute("xmlns:xmlns:atom", "http://www.w3.org/2005/Atom");
        $channel = $base->addChild('channel');
        $atomLink = $channel->addChild('atom:atom:link');
        $atomLink->addAttribute('href', "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $atomLink->addAttribute('rel', 'self');
        $atomLink->addAttribute('type', 'application/rss+xml');
        $config = \Extensions\Config::get();
        $config = $config->blog;
        $channel->addChild('title', $config->blogName);
        $channel->addChild('link', "http://" . $_SERVER['HTTP_HOST']);
        $channel->addChild('description', $config->blogDescription);
        $items = $this->get(false, "timestamp DESC, id", $limit);
        foreach ($items as $item) {
            $it = $channel->addChild('item');
            $it->addChild('title', $item->getTitle());
            $it->addChild('link', 'http://localhost.com'); // replace with post url
            $it->addChild('guid', 'http://localhost.com?' . rand(0, 450)); // replace with post url
            $it->addChild('pubDate', $item->getTimestamp()
                ->format(\DateTime::RSS));
            $it->addChild('description', htmlspecialchars($item->getPreview()));
        }
        return $base->asXML();
    }

    /**
     * Increase BlogView count by 1
     *
     * @return boolean
     */
    public function increaseBlogView()
    {
        try {
            $blogViews = new BlogViews();
            $blogViews->setPost($this);
            $blogViews->Save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Return the post total views
     *
     * @param \DateTime $initDate            
     * @param \DateTime $finalDate            
     * @return number
     */
    public function getViews(\DateTime $initDate = null, \DateTime $finalDate = null, $group = false)
    {
        $blogViews = new BlogViews();
        $blogViews->setPost($this);
        $total = $blogViews->getTotalViews($initDate, $finalDate, $group);
        return $total;
    }

    /**
     * Return a set of posts that corresponds to page $page, based on blog/postsPerPage directive on config.xml file
     *
     * @param integer $page            
     * @return multitype:\Model\mixed,array,boolean
     */
    public function getPage($page)
    {
        $config = \Extensions\Config::get();
        $perPage = $config->blog->postsPerPage;
        if ($perPage == 0 || ! $perPage) {
            return $this->get("visible", "timestamp DESC, id", false);
        } else {
            $page -= 1;
            if ($page < 0) {
                $page = 0;
            }
            $start = $page * $perPage;
            return $this->get("visible", "timestamp DESC, id", "$perPage OFFSET $start");
        }
    }

    /**
     * Return the total of pages by counting the number of active posts, based on blog/postsPerPage directive on config.xml file
     *
     * @return file
     */
    public function totalPages()
    {
        $config = \Extensions\Config::get();
        $perPage = $config->blog->postsPerPage;
        $totalPosts = count($this->get("visible", "id", false));
        return ceil($totalPosts / $perPage);
    }
}