<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Configurações do Blog" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$blog = new Model\Blog();
$config = \Extensions\Config::get();
$configvalues = $config->blog;

if($_POST){
    try{
        $config->blog->sendNotificationToMailing = isset($_POST['sendnotification']) ? 1 : 0;
        $config->blog->postsPerPage = $_POST['postsperpage'];
        \Extensions\Config::Save();
        $class = "success";
        $result = "Informações atualizadas";
    }catch(Exception $e){
        $class = "danger";
        $result = $e->getMessage();
    }
    echo \Extensions\Messages::Message($class, $result);
}
?>

<h2 class="page-header">Configurações do blog</h2>

<form method="post">
	<fieldset>
		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="sendnotification" <?php echo ($configvalues->sendNotificationToMailing > 0 ? " checked=\"checked\"" : "");?>>
					<i class="fa fa-square-o"></i>
					Enviar e-mail aos usuários quando houver novas publicações
				</label>
			</div>
		</div>

		<div class="form-group">
			<label for="postsperpage">Número de posts por página</label>
			<input type="text" class="number form-control" id="postsperpage" name="postsperpage" value="<?php echo $configvalues->postsPerPage;?>">
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</fieldset>
</form>