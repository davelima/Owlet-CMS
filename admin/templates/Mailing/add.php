<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Mailing" => "/admin/mailing/dashboard/",
    "Adicionar novo e-mail" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$mailing = new Model\Mailing();
?>

<div class="row">
	<form method="post" accept-charset="utf-8">
		<fieldset>
			<div class="col-xs-12 col-md-8">
<?php
if ($_POST) {
    try {
        $mailing->setEmail($_POST['email']);
        $mailing->Save();
        $type = "success";
        $message = "Email registrado com sucesso!";
    } catch (Exception $e) {
        $type = "danger";
        $message = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $message);
}
?>
				<h2 class="page-header">Adicionar e-mail ao mailing</h2>
				<div class="form-group">
					<input type="email" name="email" class="form-control" required>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success">Adicionar</button>
					<a href="mailing/dashboard/" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancelar</a>
				</div>
			</div>
		</fieldset>
	</form>
</div>