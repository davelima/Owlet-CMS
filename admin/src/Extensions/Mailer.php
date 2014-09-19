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
namespace Extensions;

/**
 * Send e-mails
 * This class use data on config file
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @version r1.1
 * @namespace Extensions
 * @license Apache 2.0
 * @see Config
 * @todo Implement Templates
 */
class Mailer
{

    /**
     * The PHPMailer Object
     *
     * @var PHPMailer\PHPMailer
     */
    private $PHPMailerObj;

    /**
     * The Config object
     *
     * @var \SimpleXMLElement
     * @see Config
     */
    private $config;

    /**
     * The recipient
     *
     * @var array
     */
    public $recipient = array(
        "email" => null,
        "name" => null
    );

    /**
     * The message body
     *
     * @var string
     */
    public $message;

    /**
     * Template to put $this->message inside [NOT IMPLEMENTED YET]
     *
     * @var string
     */
    public $template;

    /**
     * Subject of the message
     *
     * @var string
     */
    public $subject;

    /**
     * Enable or not to show the unsubscription link on the end of the message
     *
     * @var boolean
     */
    public $showUnsubscribeLink = false;

    /**
     * Message that will be appended on every e-mail if $this->showUnsubscribeLink option is enabled (The unsubscribe link (%LINK%) is generated automatically)
     *
     * @var string
     */
    public $unsubscribeLinkFormat = "Caso não queira mais receber e-mails, <a href=\"%LINK%\" target=\"_blank\">clique aqui</a>.";

    /**
     * Set $this->config and $this->PHPMailerObj
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = Config::get();
        $this->PHPMailerObj = new PHPMailer\PHPMailer();
    }

    /**
     * Send the e-mail
     *
     * @return boolean
     */
    public function Send()
    {
        $this->PHPMailerObj->SetFrom($this->config->mailer->sender, $this->config->mailer->senderName);
        $this->PHPMailerObj->addAddress($this->recipient['email'], $this->recipient['name']);
        $this->PHPMailerObj->CharSet = "UTF-8";
        $this->PHPMailerObj->IsHTML(1);
        $this->PHPMailerObj->IsSMTP();
        if ($this->config->mailer->auth != "none") {
            $this->PHPMailerObj->SMTPAuth = true;
            $this->PHPMailerObj->Host = $this->config->mailer->host->__toString();
            $this->PHPMailerObj->Port = $this->config->mailer->port->__toString();
            $this->PHPMailerObj->SMTPSecure = $this->config->mailer->auth->__toString();
            $this->PHPMailerObj->Username = $this->config->mailer->username->__toString();
            $this->PHPMailerObj->Password = $this->config->mailer->password->__toString();
        }
        
        $this->PHPMailerObj->Subject = $this->subject;
        $this->PHPMailerObj->Body = $this->message;
        
        if ($this->showUnsubscribeLink) {
            $mailing = new \Model\Mailing();
            $recipient = $mailing->getByColumn("email", $this->recipient['email']);
            if (isset($recipient[0])) {
                $mailingConfig = Config::get();
                $token = $recipient[0]->getToken();
                $unsubscribeLink = $mailingConfig->mailing->cancelURL . "?token=" . $token;
                $unsubscribeLink = str_replace("%LINK%", $unsubscribeLink, $this->unsubscribeLinkFormat);
                $this->PHPMailerObj->Body .= <<<HTML
<br><br>
<p><small>{$unsubscribeLink}</small></p>       
HTML;
            }
        }
        
        return $this->PHPMailerObj->Send();
    }
}