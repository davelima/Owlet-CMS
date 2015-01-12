<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Configurações" => "/admin/setup/setup/",
    "Temas" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$config = Extensions\Config::get();
?>

<div class="row">
	<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<fieldset>
			<div class="col-xs-12 col-md-8">
<?php
if ($_POST) {
    try {
        $config->theming->theme = $_POST['theme'];
        Extensions\Config::Save();
        $type = "success";
        $message = "Tema atualizado! Atualize a página para visualizar as mudanças.";
        $config = Extensions\Config::get();
    } catch (Exception $e) {
        $type = "danger";
        $message = $e->getMessage();
    }
    echo Extensions\Messages::Message($type, $message);
}
?>
				<h2 class="page-header">Temas</h2>


				<div class="form-group">
					<label for="theme">Escolha um tema</label>
					<select name="theme" size="1" class="form-control">
						<option value="default">Tema padrão</option>
<?php
$themesObj = new Extensions\Themes();
$currentTheme = $themesObj->getCurrentTheme();
foreach ($themesObj->listThemes() as $theme) {
    ?>
                        <option <?php echo ($currentTheme == $theme['filename'] ? "selected='selected'" : "");?> value="<?php echo $theme['filename'];?>"><?php echo $theme['themename'];?></option>
<?php
}
?>
					</select>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>

			</div>
		</fieldset>
	</form>
</div>