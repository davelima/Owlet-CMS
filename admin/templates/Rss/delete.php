<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "RSS Feed" => "/admin/rss/dashboard/",
    "Apagar fonte de notícias" => "#"
);
require_once("inc/breadcrumbs.php");
?>

<h2 class="page-header">RSS Feeds</h2>

<?php
if(isset($_GET['id'])){
    try{
        $rss = new Model\RSS();
        $rss = $rss->getByid($_GET['id']);
        $rss->Remove();
        $resultado = "Fonte de notícias apagada com sucesso!";
    }catch(Exception $e){
        $resultado = $e->getMessage();
    }
    echo
<<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="rss/dashboard/";
});
</script>
RESULT;
}
?>