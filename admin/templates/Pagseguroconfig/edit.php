<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Configurações do PagSeguro" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");
$pagseguroconfig = new Model\PagSeguro\PagSeguroConfig();
if(!isset($_GET['id'])){
    header("Location: /admin/");
    exit;
}
$info = $pagseguroconfig->getById($_GET['id']);
?>

<div class="row">
    <form method="post" accept-charset="utf-8">
        <fieldset>
            <div class="col-xs-12 col-md-8">
<?php
if($_POST){
    try{
        $pagseguroconfig->setEmail($_POST['email']);
        $pagseguroconfig->setToken($_POST['token']);
        $pagseguroconfig->setId($_GET['id']);
        $pagseguroconfig->Save();
        $type = "success";
        $msg = "Configurações atualizadas!";
    }catch(Exception $e){
        $type = "danger";
        $msg = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $msg);
}
?>
                <h2 class="page-header">Configurações PagSeguro</h2>
                <h5>Altere as configurações de pagamento integradas ao PagSeguro</h5>
                <div class="form-group">
                    <label>E-mail</label>
                    <input class="form-control" type="email" name="email" value="<?php echo $info->getEmail();?>" required>
                </div>
                <div class="form-group">
                    <label>Token</label>
                    <input class="form-control" type="text" name="token" value="<?php echo $info->getToken();?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>