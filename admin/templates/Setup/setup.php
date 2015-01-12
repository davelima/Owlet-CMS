<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Confiurações" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$admin = new Model\Administrators();
if (! $admin->isRoot()) {
    header("Location: /admin/");
    exit();
}
$config = Extensions\Config::get();
?>

<div class="row">
<?php
if ($_POST) {
    try {
        $config->title = $_POST['title'];
        $config->blog->blogName = $_POST['title'];
        $config->tickets->title = $_POST['title'];
        Extensions\Config::Save();
        $type = "success";
        $message = "Informações atualizadas com sucesso!";
        $config = Extensions\Config::get();
    } catch (Exception $e) {
        $type = "danger";
        $message = $e->getMessage();
    }
    echo Extensions\Messages::Message($type, $message);
}
?>
	<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<fieldset>
			<div class="col-xs-12 col-md-8">
				<h2 class="page-header">Configurações</h2>


				<div class="form-group">
					<label for="title">Título do website</label>
					<input type="text" name="title" id="title" value="<?php echo $config->title;?>" class="form-control" required>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>

			</div>
		</fieldset>
	</form>
</div>