<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Administradores" => "/admin/blog/dashboard/",
    "Apagar categoria do blog" => "#"
);
require_once("inc/breadcrumbs.php");
?>

<h2 class="page-header">Categorias</h2>

<?php
if(isset($_GET['id'])){
    try{
        $category = new Model\Categories();
        $category = $category->getById($_GET['id']);
        $category->Remove();
        $resultado = "Categoria apagada com sucesso!";
    }catch(Exception $e){
        $resultado = $e->getMessage();
    }
    echo
<<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="categories/dashboard/";
});
</script>
RESULT;
}
?>