<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Mensagens" => "/admin/messages/dashboard/",
);
require_once("inc/breadcrumbs.php");
$messages = new Model\Messages();
?>

<h2 class="page-header">Mensagens de contato</h2>

<table class="table">
    <thead>
        <th scope="col">Nome</th>
        <th scope="col">Data</th>
        <th scope="col" style="width:50px;"></th>
    </thead>
    <tbody>
<?php
$list = $messages->getAll();
foreach($list as $message){
    $class = ($message->isRead() ? "" : "class=\"alert-info text-bold\"");
?>
        <tr <?php echo $class;?>>
            <td><?php echo $message->getName();?></td>
            <td><?php echo $message->getTimestamp()->format('d/m/Y H:i');?></td>
            <td>
                <a href="messages/read/<?php echo $message->getId();?>/"><i class="fa fa-eye"></i></a>
                <a href="messages/delete/<?php echo $message->getId();?>/" class="delete" data-confirm="Deseja realmente apagar esta mensagem?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>