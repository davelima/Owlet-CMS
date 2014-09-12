<?php
require_once ("../admin/src/bootstrap.php");
header("Content-Type: Application/JSON");
$result = array(
    "status" => 200,
    "statusText" => "OK"
);

if ($_POST) {
    try {
        $config = Extensions\Config::get();
        $config->mailer->sender = $_POST['emailaccount'];
        $config->mailer->senderName = $_POST['name'];
        $config->mailer->receiver = $_POST['emailaccount'];
        $config->mailer->host = $_POST['emailhost'];
        $config->mailer->port = $_POST['emailport'];
        $config->mailer->auth = $_POST['emailauth'];
        $config->mailer->username = $_POST['emailaccount'];
        $config->mailer->password = $_POST['emailpassword'];
        Extensions\Config::Save();
        
        $mailer = new Extensions\Mailer();
        $mailer->message = "Esta é uma mensagem de teste automática criada pelo seu CMS. Você ter recebido esta mensagem significa que suas configurações de SMTP estão corretas.";
        $mailer->subject = "Configuração de e-mail";
        $mailer->recipient = array(
            "name" => $_POST['name'],
            "email" => $_POST['emailaccount']
        );
        $mailer->Send();
    } catch (Exception $e) {
        $result["status"] = 500;
        $result["message"] = $e->getMessage();
    }
}

print_r(json_encode($result));