<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "RSS Feeds" => "/admin/rss/dashboard/",
    "Atualizar fonte de notícias" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
if (! isset($_GET['id'])) {
    header("Location: /admin/categories/dashboard/");
    exit();
}
$rss = new Model\RSS();
$info = $rss->getById($_GET['id']);
?>

<div class="row">
	<form method="post" accept-charset="utf-8">
		<fieldset>
			<div class="col-xs-12 col-md-8">
<?php
if ($_POST) {
    try {
        $rss->setUrl($_POST['url']);
        $rss->setId($_GET['id']);
        $rss->Save();
        $type = "success";
        $message = "Fonte de notícias atualizada com sucesso!";
        $info = $rss->getById($_GET['id']);
    } catch (Exception $e) {
        $type = "danger";
        $message = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $message);
}
?>
				<h2 class="page-header">Atualizar fonte de notícias</h2>
				<div class="form-group">
					<input type="url" name="url" class="form-control" value="<?php echo $info->getUrl();?>" required>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success">Salvar</button>
					<a href="rss/dashboard/" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancelar</a>
				</div>
			</div>
		</fieldset>
	</form>
</div>