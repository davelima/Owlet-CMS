<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Usuários" => "/admin/users/dashboard/",
    "Apagar conta de usuário" => "#"
);
require_once("inc/breadcrumbs.php");
?>

<h2 class="page-header">Usuários</h2>

<?php
if(isset($_GET['id'])){
    try{
        $admin = new Model\Users();
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
   location.href="users/dashboard/";
});
</script>
RESULT;
}
?>