<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Comentários" => "/admin/blog/comments/",
    "Responder comentário" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");
if(!isset($_GET['id'])){
    header("Location: /admin/blog/comments/");
    exit;
}
$comments = new Model\Comments();
$comments->setReply($_GET['id']);
$comment = $comments->getById($_GET['id']);
$post = $comment->getPost();
$comments->setPost($post);
?>

<div class="row">
    <form method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
            <div class="col-xs-12 col-md-8">
<?php
if($_POST){
    try{
        $comments->setBody($_POST['body']);
        $comments->setName("Administrador"); # Deverá ser dinâmico
        $comments->setPost($post->getId());
        $comments->Save();
        $type = "success";
        $result = "Comentário respondido!";
    }catch(Exception $e){
        $type = "danger";
        $result = $e->getMessage();
    }
    echo Extensions\Messages::Message($type, $result);
}
?>
                <h2 class="page-header">Responder comentário</h2>
                <h5>Publicação: <?php echo $post->getTitle();?></h5>
                <div class="form-group">
                    <label>Digite sua resposta</label>
                    <textarea class="tmce form-control" name="body"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="well">
                <p>Você está respondendo ao comentário de <b><?php echo $comment->getName();?></b>:</p>"<i><?php echo $comment->getBody();?></i>"
                </div>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success">Responder</button>
            </div>
        </fieldset>
    </form>
</div>