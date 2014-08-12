<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Apagar comentário" => "#"
);
require_once("inc/breadcrumbs.php");
?>

<h2 class="page-header">Blog</h2>

<?php
if(isset($_GET['id'])){
    try{
        $comments = new Model\Comments();
        $comments = $comments->getById($_GET['id']);
        $comments->Remove();
        $resultado = "Comentário apagado com sucesso!";
    }catch(Exception $e){
        $resultado = $e->getMessage();
    }
    echo
<<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="blog/comments/";
});
</script>
RESULT;
}
?>