<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Sitemaps" => "/admin/sitemaps/dashboard/"
);
require_once ("inc/breadcrumbs.php");
$sitemaps = new Extensions\Sitemaps();
?>

<h2 class="page-header">Sitemap</h2>

<div class="row">
	<div class="col-xs-2">
		<div class="jumbotron text-center">
			<h1><?php echo (int)$sitemaps->totalLinks;?></h1>
			<p>links indexados</p>
		</div>
	</div>

	<div class="col-xs-2">
		<div class="jumbotron text-center">
			<p>
				<small><?php echo ($sitemaps->lastChange ? "Atualizado pela última vez em ".$sitemaps->lastChange->format('d/m/Y H:i') : "O sitemap nunca foi atualizado");?></small>
			</p>
		</div>
	</div>

	<div class="col-xs-2">
		<div class="jumbotron text-center">
			<a href="sitemaps/generate/" class="btn btn-success"><i class="fa fa-refresh"></i> Atualizar agora</a>
		</div>
	</div>
</div>