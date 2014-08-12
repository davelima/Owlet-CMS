<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Mensagens" => "/admin/messages/dashboard/",
);
require_once("inc/breadcrumbs.php");
if(!isset($_GET['id'])){
    header("Location: /admin/messages/dashboard/");
    exit;
}
$message = new Model\Messages();
$message = $message->getById($_GET['id']);
$fields = array(
    "name" => "Nome",
    "email" => "E-mail",
    "phone" => "Telefone",
    "body" => "Mensagem",
    "subject" => "Assunto",
    "timestamp" => "Data/hora do envio"
);
if(!$message->isRead()){
    $message->setIsRead(true);
    $message->Save();
}
$data = $message->getData();
?>

<h2 class="page-header">Mensagens de contato</h2>
<div class="well">
<?php
foreach($data as $key => $value){
    if(in_array($key, array_keys($fields)) && $value){
        if($key == "timestamp"){
            $value = $message->getTimestamp()->format('d/m/Y H:i');
        }
        echo "<p><strong>{$fields[$key]}</strong>: {$value}</p>";
    }
}
?>
<a href="messages/dashboard/" class="btn btn-info"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>