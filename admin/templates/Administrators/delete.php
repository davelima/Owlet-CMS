<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Administradores" => "/admin/administrators/dashboard/",
    "Apagar conta de administrador" => "#"
);
require_once("inc/breadcrumbs.php");
$admin = new Model\Administrators();
if(!$admin->isRoot()){
    header("Location: /admin/dashboard/");
    exit;
}
?>

<h2 class="page-header">Administradores</h2>

<?php
if(isset($_GET['id'])){
    try{
        $admin = $admin->getById($_GET['id']);
        $admin->Remove();
        $resultado = "Conta apagada com sucesso!";
    }catch(Exception $e){
        $resultado = $e->getMessage();
    }
    echo
<<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="administrators/dashboard/";
});
</script>
RESULT;
}
?>