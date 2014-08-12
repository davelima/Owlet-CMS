<?php
require_once("src/bootstrap.php");
$admin = new Model\Administrators();
if($admin->isAuthenticated()){
    header("Location: /admin");
    exit;
}
?>
<!DOCTYPE html>
<html>
<?php
require_once("inc/head.php");
?>
<body>
<div class="container-fluid">
	<div id="page-login" class="row">
		<div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div class="box">
				<div class="box-content">
					<div class="text-center">
						<h3 class="page-header">Login</h3>
<?php
if($_POST){
    try{
        $admin->Authenticate($_POST);
        if(!$admin->isAuthenticated()){
            throw new Exception("Usuário ou senha incorretos");
        }else{
            header("Location: /admin");
            exit;
        }
    }catch(Exception $e){
        echo "<div class=\"alert alert-danger\">{$e->getMessage()}</div>";
    }
}
?>
						
					</div>
					<form method="post" accept-charset="utf-8">
    					<div class="form-group">
    						<label class="control-label">Usuário</label>
    						<input type="text" class="form-control" name="username" required>
    					</div>
    					<div class="form-group">
    						<label class="control-label">Senha</label>
    						<input type="password" class="form-control" name="password" required>
    					</div>
    					<div class="text-center">
    						<button type="submit" class="btn btn-primary">Entrar</button>
    					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>