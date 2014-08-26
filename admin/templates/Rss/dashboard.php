<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "RSS Feeds" => "/admin/rss/dashboard/",
);
require_once("inc/breadcrumbs.php");
$rss = new Model\RSS();
$allSources = $rss->getAll();
?>

<h2 class="page-header">Fontes de notícias <a href="rss/addsource/" class="text-right btn btn-success btn-xs" style="float:right;"><i class="fa fa-plus-circle"></i> Adicionar nova fonte</a></h2>

<table class="table">
    <thead>
        <th scope="col">Título</th>
        <th scope="col" style="width:50px;"></th>
    </thead>
    <tbody>
<?php
foreach($allSources as $source){
?>
        <tr>
            <td><?php echo $source->getTitle();?></td>
            <td>
                <a href="rss/edit/<?php echo $source->getId();?>/"><i class="fa fa-pencil"></i></a>
                <a href="rss/delete/<?php echo $source->getId();?>/" class="delete" data-confirm="Deseja realmente remover esta fonte de notícias?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>