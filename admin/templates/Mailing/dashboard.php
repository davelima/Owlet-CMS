<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Mailing" => "/admin/mailing/dashboard/"
);
require_once ("inc/breadcrumbs.php");
$mailing = new Model\Mailing();
?>

<h2 class="page-header">Mailing
    <a href="templates/Mailing/export.php" style="float:right;" title="Baixar .CSV"><i class="fa fa-download"></i></a>
    <a href="mailing/add/" style="float:right;margin-right:10px;" title="Registrar novo e-mail" class="text-success"><i class="fa fa-plus-circle"></i></a>
</h2>
<table class="table">
	<thead>
       <th scope="col" style="width:20px"></th>
		<th scope="col">E-mail</th>
		<th scope="col" style="width:140px;">Data de cadastro</th>
		<th scope="col" style="width: 50px;"></th>
	</thead>
	<tbody>
<?php
$list = $mailing->getAll();
foreach($list as $item){
?>
        <tr>
            <td><i class="fa fa-circle text-<?php echo ($item->getStatus() ? "success" : "danger");?>"></i></td>
            <td><?php echo $item->getEmail();?></td>
            <td><?php echo $item->getTimestamp()->format('d/m/Y H:i');?></td>
            <td>
                <a href="mailing/delete/<?php echo $item->getId();?>/" title="Apagar" class="delete" data-confirm="Deseja realmente apagar este e-mail do mailing?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
	</tbody>
</table>