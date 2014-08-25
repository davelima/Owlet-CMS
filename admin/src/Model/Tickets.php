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
 * Manage support tickets
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @version r1.0
 * @license Apache 2.0
 */
class Tickets extends Base
{

    /**
     * Table to save data
     */
    const TABLE = "tickets";

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "title" => null,
        "body" => null,
        "member" => null,
        "status" => null,
        "id" => null
    );

    /**
     * Available ticket statuses
     *
     * @staticvar array
     */
    public static $statuses = array(
        "waiting_admin" => "Aguardando administrador",
        "waiting_user" => "Aguardando usuário",
        "closed" => "Encerrado"
    );

    /**
     * Implementation of Save() method
     *
     * @see \Model\Base::Save()
     */
    public function Save()
    {
        $required = array(
            "title" => "Título do chamado",
            "body" => "Texto do chamado"
        );
        
        $config = \Extensions\Config::get();
        if ($this->getMember() instanceof Users) {
            $memberObj = clone $this->getMember();
        } else {
            $memberObj = new Users();
            $memberObj = $memberObj->getById($this->getMember());
            $this->setMember($memberObj);
        }
        $this->validateData($required);
        parent::Save();
        $id = $this->get("member = '{$memberObj->getId()}'", "id", 1);
        $id = $id[0];
        $id = $id->getId();
        if ($config->tickets->sendMail && ! $this->id && $config->mailer->sender) {
            $mailer = new \Extensions\Mailer();
            $mailer->subject = "Ticket criado #$id";
            $mailer->message = <<<MESSAGE
            <p>Olá, {$memberObj->getName()}, um ticket acabou de ser aberto no {$config->tickets->title} através da sua conta. Em breve você receberá uma resposta.</p>
            <p>Detalhes do seu ticket:</p>
            {$this->getBody()}
MESSAGE;
            $mailer->recipient = array(
                "email" => $memberObj->getEmail(),
                "name" => $memberObj->getName()
            );
            $mailer->Send();
        }
    }

    /**
     * Return the last response of a ticket
     * If there's no reply, return the ticket object
     *
     * @return \Model\TicketResponses|\Model\Tickets
     */
    public function getLastReply()
    {
        $responses = new TicketResponses();
        $lastReply = $responses->get("ticket = {$this->getId()}", "timestamp DESC, id", 1);
        if (count($lastReply)) {
            return $lastReply[0];
        } else {
            return $this;
        }
    }

    /**
     * Return ticket's author information
     *
     * @return \Model\Users|void
     */
    public function getAuthor()
    {
        if ($this->member) {
            $users = new Users();
            return $users->getById($this->member);
        }
    }

    /**
     * Implementation of validadeData() method
     *
     * @see \Model\Base::validateData()
     */
    protected function validateData(array $required)
    {
        if (! $this->status) {
            $this->status = "waiting_admin";
        }
        $this->setMember($this->member->getId());
        
        parent::validateData($required);
    }

    /**
     * Close an ticket
     *
     * @return void
     */
    public function Close()
    {
        $this->status = "closed";
        $this->Save();
    }

    /**
     * Reopen a ticket
     *
     * @return void
     */
    public function reOpen()
    {
        $this->status = "waiting_admin";
        $this->Save();
    }
}