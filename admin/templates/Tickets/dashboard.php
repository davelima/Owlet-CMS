<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Chamados" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");
$tickets = new Model\Tickets();
$users = new Model\Users();
$tickets = $tickets->getAll();
?>

<h2 class="page-header">Chamados</h2>

<table class="table">
    <thead>
        <th scope="col">Título</th>
        <th scope="col">Usuário</th>
        <th scope="col">Criado em</th>
        <th scope="col">Última interação</th>
        <th scope="col">Status</th>
        <th scope="col" style="width:64px;"></th>
    </thead>
    <tbody>
<?php
foreach($tickets as $ticket){
    $ticket->setMember($users->getById($ticket->getMember()));
?>
        <tr>
            <td><?php echo $ticket->getTitle();?></td>
            <td><?php echo $ticket->getMember()->getName();?></td>
            <td><?php echo $ticket->getTimestamp()->format('d/m/Y H:i');?></td>
            <td><?php echo $ticket->getLastReply()->getTimestamp()->format('d/m/Y H:i');?></td>
            <td><?php echo $ticket::$statuses[$ticket->getStatus()];?></td>
            <td>
                <a href="tickets/reply/<?php echo $ticket->getId();?>/"><i class="fa fa-reply"></i></a>
                <a href="tickets/delete/<?php echo $ticket->getId();?>/" title="Apagar" class="delete" data-confirm="Deseja realmente apagar este ticket e todas as respostas?"><i class="fa fa-times text-danger"></i></a>
<?php
    if($ticket->getStatus()!="closed"){
?>
                <a href="tickets/close/<?php echo $ticket->getId();?>/" title="Fechar ticket"><i class="fa fa-minus-circle"></i></a>
<?php
    }else{
?>
                <a href="tickets/reopen/<?php echo $ticket->getId();?>/" title="Reabrir ticket"><i class="fa fa-check-circle"></i></a>
<?php
    }
?>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>