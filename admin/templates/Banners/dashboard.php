<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Banners" => "/admin/banners/dashboard/"
);
require_once ("inc/breadcrumbs.php");
$banners = new Model\Banners();
?>

<h2 class="page-header">Banners do site</h2>

<table class="table table-banners">
	<thead>
		<th scope="col" style="width: 16px;"></th>
		<th scope="col" style="width: 300px;"></th>
		<th scope="col">Título</th>
		<th scope="col" style="width: 150px;">Visível desde</th>
		<th scope="col" style="width: 150px;">Visível até</th>
		<th scope="col">Permanente</th>
		<th scope="col" style="width: 70px;"></th>
	</thead>
	<tbody>
<?php
$list = $banners->getAll("position");
$savePath = __DIR__ . \Extensions\PHPImageWorkshop\ImageWorkshop::UPLOAD_PATH . "/banners/";
foreach ($list as $banner) {
    $status = ($banner->isActive() ? "success" : "danger");
    $icon = ($banner->isActive() ? "check" : "times");
    $textStatus = ($banner->isActive() ? "Banner ativo" : "Banner inativo")?>
        <tr title="<?php echo $textStatus;?>" data-id="<?php echo $banner->getId();?>">
			<td>
				<span class="text-<?php echo $status;?>">
					<i class="fa fa-<?php echo $icon;?>"></i>
				</span>
			</td>
			<td>
				<img src="/uploads/banners/<?php echo $banner->getSrc();?>" style="width: 300px;">
			</td>
			<td><?php echo $banner->getTitle();?></td>
			<td><?php echo $banner->getSince()->format('d/m/Y H:i');?></td>
			<td><?php echo $banner->getUntil()->format('d/m/Y H:i');?></td>
			<td><?php echo $banner->getPermanent() ? "Sim" : "Não";?></td>
			<td>
				<a href="banners/edit/<?php echo $banner->getId();?>/" title="Editar">
					<i class="fa fa-pencil"></i>
				</a>
				<a href="banners/delete/<?php echo $banner->getId();?>/" title="Apagar" class="delete" data-confirm="Deseja realmente apagar este banner?">
					<i class="fa fa-times text-danger"></i>
				</a>
			</td>
		</tr>    
<?php
}
?>
    </tbody>
</table>