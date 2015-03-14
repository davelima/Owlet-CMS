<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/"
);
require_once ("inc/breadcrumbs.php");
$blog = new Model\Blog();
$today = new DateTime();
?>

<h2 class="page-header">Publicações do blog</h2>

<table class="table">
	<thead>
		<tr>
			<th scope="col" style="width: 16px;"></th>
			<th scope="col">Título</th>
			<th scope="col">Data</th>
			<th scope="col" style="width:50px;">Views</th>
			<th scope="col" style="width: 90px;"></th>
		</tr>
	</thead>
	<tbody>
<?php
$list = $blog->getAll("timestamp DESC, id", true);
foreach ($list as $post) {
    ?>
        <tr>
			<td>
				<a href="blog/visible/<?php echo $post->getId();?>/">
					<i class="fa fa-circle text-<?php echo ($post->getVisible() ? "success" : "danger");?>"></i>
			</a>
			</td>
			<td><?php echo $post->getTitle();?></td>
			<td><?php echo $post->getTimestamp()->format('d/m/Y');?></td>
			<td><?php echo $post->getViews($post->getTimestamp(), $today, false);?></td>
			<td>
				<a href="blog/comments/<?php echo $post->getId();?>/" title="Comentários">
					<i class="fa fa-comments"></i>
				</a>
				<a href="blog/edit/<?php echo $post->getId();?>/" title="Editar">
					<i class="fa fa-pencil"></i>
				</a>
				<a href="blog/graph/<?php echo $post->getId();?>/" title="Visualizações">
				    <i class="fa fa-line-chart"></i>
				</a>
				<a href="blog/delete/<?php echo $post->getId();?>/" title="Apagar" class="delete" data-confirm="Deseja realmente apagar esta publicação?">
					<i class="fa fa-times text-danger"></i>
				</a>
			</td>
		</tr>
<?php
}
?>
    </tbody>
</table>