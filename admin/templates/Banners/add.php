<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Banners" => "/admin/banners/dashboard/",
    "Novo banner" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$banners = new Model\Banners();
?>

<div class="row">
	<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<fieldset>
			<div class="col-xs-12 col-md-8">
<?php
if($_POST){
    try{
        $banners->setTitle($_POST['title']);
        $banners->setSrc($_FILES['image']);
        $banners->setPermanent((isset($_POST['permanent'])));
        $banners->setSince($_POST['since']);
        $banners->setUntil($_POST['until']);
        $banners->setLink($_POST['link']);
        $banners->Save();
        $type = "success";
        $msg = "Banner adicionado com sucesso!";
    }catch(Exception $e){
        $type = "danger";
        $msg = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $msg);
}
?>
				<h2 class="page-header">Novo banner</h2>
				<h5>Envie um banner para ser exibido na página principal do site</h5>
				
				<div class="form-group">
				    <label for="title">Título *</label>
				    <input type="text" id="title" name="title" class="form-control" required>
				</div>
				
				<div class="form-group">
				    <label for="image">Imagem (<?php echo Model\Banners::WIDTH."x".Model\Banners::HEIGHT."px";?> / <?php echo ini_get("upload_max_filesize");?>) *</label>
				    <input type="file" id="image" name="image" class="btn btn-default" accept="image/*" required>
				</div>
				
				<div class="form-group">
                    <div class="checkbox">
                        <label for="permanent">
                            <input type="checkbox" id="permanent" name="permanent" data-toggle="#sinceuntil" class="check">
                            Banner permanente <i class="fa fa-square-o"></i>
                        </label>
                    </div>
				</div>
				
				<div class="form-group" id="sinceuntil" style="display:none;">
				    <div class="row">
                        <div class="col-xs-4">
                            <label for="since">Visível a partir de:</label>
                            <br>
                            <input type="text" name="since" class="datetime" value="<?php echo date("Y-m-d H:i:s");?>">
                        </div>
    
    				    <div class="col-xs-4">
        				    <label for="until">Visível até:</label>
        				    <br>
        				    <input type="text" name="until" class="datetime" value="<?php echo date("Y-m-d H:i:s");?>">
    				    </div>
    				    
    				    <div class="col-xs-4">
    				    
    				    </div>
				    </div>
				</div>
				
				<div class="form-group">
				    <label for="link">Link do banner</label>
				    <input type="url" name="link" id="link" class="form-control">
				</div>
			</div>
			<div class="col-xs-12">
                <button type="submit" class="btn btn-success">Adicionar</button>
			</div>
		</fieldset>
	</form>
</div>