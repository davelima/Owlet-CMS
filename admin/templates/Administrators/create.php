<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Administradores" => "/admin/administrators/dashboard/",
    "Criar administrador" => "/admin/administrators/create/"
);
require_once("inc/breadcrumbs.php");
$admin = new Model\Administrators();
if(!$admin->isRoot()){
    header("Location: /admin/dashboard/");
    exit;
}
?>

<div class="row">
	<div class="col-xs-12 col-md-6">
<?php
if($_POST){
    try{
        $admin->setName($_POST['name']);
        $admin->setUserName($_POST['username']);
        $admin->setPassword($_POST['password']);
        $admin->setEmail($_POST['email']);
        $_POST['permissions'] = array();
        $admin->setPermissions($_POST['permissions']);
        $admin->Save();
        $class = "success";
        $result = "Conta criada com sucesso!";
    }catch(Exception $e){
        $class = "danger";
        $result = $e->getMessage();
    }
    echo \Extensions\Messages::Message($class, $result);
}
?>
		<h2 class="page-header">Criar administrador</h2>
		<h5>Preencha os dados para criar uma nova conta de administrador</h5>
		<form method="post" accept-charset="utf-8">
			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text" name="name" id="name" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="username">Login</label>
				<input type="text" name="username" id="username" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="password">Senha</label>
				<input type="password" name="password" id="password" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="email">E-mail</label>
				<input type="email" name="email" id="email" class="form-control">
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
				<button type="submit" class="btn btn-info">Cadastrar</button>
			</div>
		</form>
	
	</div>
	<div class="col-md-6 hidden-xs hidden-sm">
		<div class="well">
			<h4></h4>
			<p>Se mais pessoas forem utilizar o sistema, você pode criar novas contas para cada uma delas.</p>
			<p>
				Os administradores criados por aqui serão considerados administradores secundários, isso significa que eles terão acesso somente as páginas de gerenciamento de conteúdo. Portanto, os administradores secundários<b>não</b> poderão criar, editar ou excluir contas de administradores. Apenas o seu usuário tem acesso a estas funções.
				<br>
				<br>
				Usando o campo <b>Permissões</b>, pode determinar a qual módulo este novo administrador terá acesso.
			</p>
		</div>
	</div>
</div>