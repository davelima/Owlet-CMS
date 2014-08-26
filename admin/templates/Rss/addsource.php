<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "RSS Feeds" => "/admin/rss/dashboard/",
    "Adicionar nova fonte de notícias" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$rss = new Model\RSS();
?>

<div class="row">
	<form method="post" accept-charset="utf-8">
		<fieldset>
			<div class="col-xs-12 col-md-8">
<?php
if ($_POST) {
    try {
        $rss->setUrl($_POST['url']);
        $rss->Save();
        $type = "success";
        $message = "Fonte de notícias adicionada com sucesso!";
    } catch (Exception $e) {
        $type = "danger";
        $message = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $message);
}
?>
				<h2 class="page-header">Adicionar fonte de notícias</h2>
				<div class="form-group">
					<input type="url" name="url" class="form-control" required>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success">Adicionar</button>
					<a href="rss/dashboard/" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancelar</a>
				</div>
			</div>
		</fieldset>
	</form>
</div>