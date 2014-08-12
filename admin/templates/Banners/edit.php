<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Banners" => "/admin/banners/dashboard/",
    "Atualizar banner" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
if (! isset($_GET['id'])) {
    header("Location: /admin/banners/dashboard/");
    exit();
}
$banners = new Model\Banners();
$info = $banners->getByid($_GET['id']);
?>

<div class="row">
	<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<fieldset>
			<div class="col-xs-12 col-md-8">
<?php
if ($_POST) {
    try {
        $banners->setTitle($_POST['title']);
        $src = (strlen($_FILES['image']['name']) ? $_FILES['image'] : $info->getSrc());
        $banners->setSrc($src);
        $banners->setPermanent((isset($_POST['permanent'])));
        $banners->setSince($_POST['since']);
        $banners->setUntil($_POST['until']);
        $banners->setLink($_POST['link']);
        $banners->setId($_GET['id']);
        $banners->Save();
        $type = "success";
        $msg = "Banner atualizado com sucesso!";
        $info = $banners->getById($_GET['id']);
    } catch (Exception $e) {
        $type = "danger";
        $msg = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $msg);
}
?>
				<h2 class="page-header">Atualizar banner</h2>
				<h5>Atualize as informações do banner a ser exibido</h5>

				<div class="form-group">
					<label for="title">Título *</label>
					<input type="text" id="title" name="title" class="form-control" value="<?php echo $info->getTitle();?>" required>
				</div>

				<div class="form-group">
					<label for="image">Imagem (<?php echo Model\Banners::WIDTH."x".Model\Banners::HEIGHT."px";?>) *</label>
					<input type="file" id="image" name="image" class="btn btn-default" accept="image/*">
					<img src="/upload/banners/<?php echo $info->getSrc();?>" alt="Banner" title="Banner atual">
				</div>

				<div class="form-group">
					<div class="checkbox">
						<label for="permanent">
							<input type="checkbox" id="permanent" name="permanent" data-toggle="#sinceuntil" <?php echo ($info->getPermanent() ? "checked" : "");?> class="check">
							Banner permanente
							<i class="fa fa-square-o"></i>
						</label>
					</div>
				</div>
				<div class="form-group" id="sinceuntil" <?php echo ($info->getPermanent() ? "" : "style='display:none;text-align:center;'");?>>
					<div class="row">
						<div class="col-xs-4">
							<label for="since">Visível a partir de:</label>
							<br>
							<input type="text" name="since" class="datetime" value="<?php echo $info->getSince()->format('Y-m-d H:i');?>">
						</div>

						<div class="col-xs-4">
							<label for="until">Visível até:</label>
							<br>
							<input type="text" name="until" class="datetime" value="<?php echo $info->getUntil()->format('Y-m-d H:i');?>">
						</div>

						<div class="col-xs-4"></div>
					</div>
				</div>

				<div class="form-group">
					<label for="link">Link do banner</label>
					<input type="url" name="link" id="link" class="form-control" value="<?php echo $info->getLink();?>">
				</div>
			</div>
			<div class="col-xs-12">
				<button type="submit" class="btn btn-success">Atualizar</button>
			</div>
		</fieldset>
	</form>
</div>