<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Administradores" => "/admin/administrators/dashboard/",
    "Criar administrador" => "/admin/administrators/create/"
);
require_once("inc/breadcrumbs.php");
if(!isset($_GET['id'])){
    header("Location: /admin/administrators/dashboard/");
    exit;
}
$admin = new Model\Administrators();
if($_GET['id']!=$_SESSION['administrator']->getId()){
    if(!$admin->isRoot()){
        header("Location: /admin/dashboard/");
        exit;
    }
}
?>

<div class="row">
	<div class="col-xs-12 col-md-8">
<?php
if($_POST){
    try{
        $admin->setName($_POST['name']);
        $admin->setUserName($_POST['username']);
        if(isset($_POST['password'])&&strlen($_POST['password'])){
            $admin->setPassword($_POST['password']);
        }else{
            $info = $admin->getById($_GET['id']);
            $admin->setPassword($info->getPassword());
        }
        $admin->setEmail($_POST['email']);
        $admin->setId($_GET['id']);
        $_POST['permissions'] = array();
        $admin->setPermissions($_POST['permissions']);
        $admin->Save();
        $class = "success";
        $result = "Conta atualizada com sucesso!";
    }catch(Exception $e){
        $class = "danger";
        $result = $e->getMessage();
    }
    echo"<div class=\"alert alert-$class\" id=\"result\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> {$result}</div>";
}

$info = $admin->getById($_GET['id'], 1);
$permissions = $info->getPermissions();
if($permissions){
    $permissions = json_decode($permissions, 1);
    $permissions = implode(",", $permissions);
}

if($_SESSION['administrator']->getId()==$_GET['id']){
?>
		<h2 class="page-header">Minha conta</h2>
		<h5>Preencha os dados para atualizar os dados da sua conta</h5>
<?php
}else{
?>
		<h2 class="page-header">Editar conta de administrador</h2>
		<h5>Preencha os dados para atualizar os dados da conta de <?php echo $info->getName();?></h5>
<?php
}
?>
		<form method="post" accept-charset="utf-8">
			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text" name="name" id="name" class="form-control" value="<?php echo $info->getName();?>" required>
			</div>
			<div class="form-group">
				<label for="username">Login</label>
				<input type="text" name="username" id="username" class="form-control" value="<?php echo $info->getUserName();?>" required>
			</div>
			<div class="form-group">
				<label for="password">Senha</label>
				<input type="password" name="password" id="password" class="form-control">
			</div>
			<div class="form-group">
				<label for="email">E-mail</label>
				<input type="email" name="email" id="email" class="form-control" value="<?php echo $info->getEmail();?>">
			</div>
			<!--
			<div class="form-group">
				<label>Permissões</label>
				<br>
				<div class="row">
					<div class="col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="permissions[]" value="blog">Blog
								<i class="fa fa-square-o small"></i>
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="permissions[]" value="financeiro">Financeiro
								<i class="fa fa-square-o small"></i>
							</label>
						</div>
					</div>
				</div>
			</div>
			-->
			<div class="form-group">
				<button type="submit" class="btn btn-info">Salvar</button>
			</div>
		</form>
	
	</div>
	<div class="col-md-4 hidden-xs hidden-sm">
		<div class="well">
		  <div class="row">
		      <div class="col-xs-12">		
                    <div class="thumbnail">
                      <img src="<?php echo \Extensions\Gravatar::Retrieve($info->getEmail(), 200);?>">
                      <div class="caption">
                        <h3><?php echo $info->getName();?></h3>
                        <p>Avatar automático usando o Gravatar</p>
                        <p><a href="https://br.gravatar.com/" class="btn btn-primary" target="_blank">Alterar Gravatar</a></p>
                      </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  var permissions = "<?php echo $permissions;?>";
  permissions = permissions.split(",");
  $.each(permissions, function(i, obj){
    $('input[type=checkbox][value="'+obj+'"]').prop('checked', true).trigger('change');
  });
});
</script>