<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Mailing" => "/admin/mailing/dashboard/"
);
require_once ("inc/breadcrumbs.php");
$mailing = new Model\Mailing();
?>

<h2 class="page-header">Mailing <a href="templates/Mailing/export.php" style="float:right;" title="Baixar .CSV"><i class="fa fa-download"></i></a></h2>
<table class="table">
	<thead>
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