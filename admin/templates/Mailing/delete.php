<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Mailing" => "/admin/mailing/dashboard/",
    "Apagar registro do mailing" => "#"
);
require_once("inc/breadcrumbs.php");
?>

<h2 class="page-header">Mailing</h2>

<?php
if(isset($_GET['id'])){
    try{
        
        $mailing = new Model\Mailing();
        $mailing = $mailing->getById($_GET['id']);
        $mailing->Remove();
        $resultado = "E-mail removido com sucesso!";
    }catch(Exception $e){
        $resultado = $e->getMessage();
    }
    echo
<<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="mailing/dashboard/";
});
</script>
RESULT;
}
?>