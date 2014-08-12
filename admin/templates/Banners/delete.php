<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/banners/dashboard/",
    "Apagar banner" => "#"
);
require_once("inc/breadcrumbs.php");
?>

<h2 class="page-header">Banners</h2>

<?php
if(isset($_GET['id'])){
    try{
        $banner = new Model\Banners();
        $banner = $banner->getById($_GET['id']);
        $banner->Remove();
        $resultado = "Banner apagado com sucesso!";
    }catch(Exception $e){
        $resultado = $e->getMessage();
    }
    echo
<<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="banners/dashboard/";
});
</script>
RESULT;
}
?>