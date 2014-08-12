<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Atualizar publicação" => "/admin/blog/compose/"
);
require_once("inc/breadcrumbs.php");
if(!isset($_GET['id'])){
    header("Location: /admin/blog/dashboard/");
    exit;
}
?>

<div class="row">
    <form method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
            <div class="col-xs-12 col-md-8">
<?php
if($_POST){
     try{
        $blog = new Model\Blog();
        $blog = $blog->getById($_GET['id']);
        $blog->setTitle($_POST['title']);
        $blog->setPreview($_POST['preview']);
        $blog->setBody($_POST['body']);
        $blog->setTimestamp($_POST['timestamp']);
        $blog->setHead($_POST['head']);
        $blog->setId($_GET['id']);
        $blog->Save();
        $class = "success";
        $result = "Publicação atualizada!";
     }catch(Exception $e){
        $class = "danger";
        $result = $e->getMessage();
     }
     echo \Extensions\Messages::Message($class, $result);
}
$blog = new Model\Blog;
$info = $blog->getById($_GET['id']);
?>
                <h2 class="page-header">Atualizar publicação</h2>
                <h5>Preencha o formulário para atualizar a publicação <b><?php echo $info->getTitle();?></b></h5>
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo $info->getTitle();?>" required>
                </div>
                
                <div class="form-group">
                    <label for="preview">Pré-visualização</label>
                    <textarea class="tmce" id="preview" name="preview"><?php echo $info->getPreview();?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="body">Conteúdo</label>
                    <textarea class="tmce" id="body" style="height:300px;" name="body"><?php echo $info->getBody();?></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
            <h2 class="page-header">Informações adicionais</h2>
                <div class="form-group">
                    <label>Data/Hora da publicação</label>
                    <br>
                    <input type="text" name="timestamp" class="datetime form-control" value="<?php echo $info->getTimestamp()->format('Y-m-d H:i');?>" data-format="YYYY-MM-DD HH:mm">
                </div>
                <div class="form-group">
                    <label>Conteúdo da tag &lt;head&gt;</label>
                    <textarea name="head" class="form-control" placeholder="(Opcional) você pode inserir tags &lt;meta&gt; aqui"><?php echo $info->getHead();?></textarea>
                </div>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </fieldset>
    </form>
</div>