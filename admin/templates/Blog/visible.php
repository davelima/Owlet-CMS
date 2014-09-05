<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Alternar status de publicação" => "#"
);
require_once("inc/breadcrumbs.php");
?>

<h2 class="page-header">Blog</h2>

<?php
if(isset($_GET['id'])){
    try{
        $blog = new Model\Blog();
        $blog = $blog->getById($_GET['id']);
        $blog->setVisible($blog->getVisible() ? 0 : 1);
        $blog->Save();
        $resultado = "Status atualizado!";
    }catch(Exception $e){
        $resultado = $e->getMessage();
    }
    echo
<<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="blog/dashboard/";
});
</script>
RESULT;
}
?>