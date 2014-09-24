<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Resumo das atividades" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");
$blog = new Model\Blog();
$comments = new Model\Comments();
?>
<!--Start Dashboard 1-->
<div id="dashboard-header" class="row">
	<div class="col-xs-10 col-sm-2">
		<h3 class="hidden-xs">Resumo das atividades</h3>
		<h3 class="visible-xs">Bem-vindo!</h3>
	</div>
	<div class="clearfix visible-xs"></div>
</div>
<!--End Dashboard 1-->
<!--Start Dashboard 2-->
<div class="row-fluid hidden-xs">
	<div id="dashboard_links" class="col-xs-10 col-sm-2 pull-right">
		<ul class="nav nav-pills nav-stacked">
			<li class="active"><a href="#" class="tab-link" id="visao-geral">Visão geral</a></li>
			<li><a href="#" class="tab-link" id="blog">Comentários</a></li>
		</ul>
	</div>
	<div id="dashboard_tabs" class="col-xs-2 col-sm-10">
		<div id="dashboard-visao-geral" class="row">
			<div class="ow-box col-xs-12">
				<h4 class="page-header">Últimas publicações</h4>
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Título</th>
							<th scope="col" style="width:50px;">Data</th>
						</tr>
					</thead>
					<tbody>
<?php
$lastPosts = $blog->get(false, "timestamp DESC, id", 4);
foreach($lastPosts as $post){
?>
						<tr>
							<td><a href="#"><?php echo $post->getTitle();?> <i class="fa fa-external-link"></i></a></td>
							<td><?php echo $post->getTimestamp()->format('d/m/Y');?></td>
						</tr>
<?php
}
?>
					</tbody>
					<tfoot>
						<tr>
							<td>
								<a href="blog/dashboard/" class="text-info">Ver todas</a>
							</td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!--
			<div class="ow-box col-xs-6">
				<h4 class="page-header">Vendas</h4>
				<div class="box-content">
					<div id="vendas-2014" style="min-height: 200px;"></div>
				</div>
			</div>
			-->
		</div>
		<!--
		<div id="dashboard-vendas">
			<div class="ow-box col-xs-12">
				<h4 class="page-header">Vendas (2013-2014)</h4>
				<div class="box-content">
					<div id="vendas-geral" style="min-height:200px;"></div>
				</div>
			</div>
		</div>
		-->
		<div id="dashboard-blog">
			<div class="ow-box col-xs-12">
				<h4 class="page-header">Comentários</h4>
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Comentário</th>
							<th scope="col">Autor</th>
							<th scope="col">Publicação</th>
							<th scope="col">Data/hora</th>
						</tr>
					</thead>
					<tbody>
<?php
$lastComments = $comments->get(false, "timestamp DESC, id", 5);
foreach($lastComments as $comment){
    $replied = false;
    if($comment->getReply()){
        $replied = $comments->getById($comment->getReply());
    }
?>
						<tr<?php echo ($replied ? " title='Em resposta a {$replied->getName()}'" : "");?>>
							<td><a href="#"><?php echo $comment->getBody();?></a></td>
						    <td><?php echo $comment->getName();?></td>
							<td><a href="#"><?php echo $comment->getPost()->getTitle();?></a></td>
							<td><?php echo $comment->getTimestamp()->format('d/m/Y H:i');?></td>
						</tr>
<?php
}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div style="height: 40px;"></div>
<script type="text/javascript">
$(document).ready(function() {
	// Make all JS-activity for dashboard
	DashboardTabChecker();
	// Load Google Chart API and callback to draw test graphs
	$.getScript('http://www.google.com/jsapi?autoload={%22modules%22%3A[{%22name%22%3A%22visualization%22%2C%22version%22%3A%221%22%2C%22packages%22%3A[%22corechart%22%2C%22geochart%22]%2C%22callback%22%3A%22DrawAllCharts%22}]}');
});
</script>