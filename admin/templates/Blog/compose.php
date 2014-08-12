<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Escrever publicação" => "/admin/blog/compose/"
);
require_once("inc/breadcrumbs.php");
$tags = new Model\Tags();
?>

<div class="row">
    <form method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
            <div class="col-xs-12 col-md-8">
                <h2 class="page-header">Escrever publicação</h2>
                <h5>Preencha o formulário para criar uma publicação no blog</h5>
<?php
if($_POST){
     try{
        $blog = new Model\Blog();
        $blog->setTitle($_POST['title']);
        $blog->setPreview($_POST['preview']);
        $blog->setBody($_POST['body']);
        $blog->setTimestamp($_POST['timestamp']);
        $blog->setHead($_POST['head']);
        if(isset($_POST['category'])){
            $blog->setCategory($_POST['category']);
        }
        $blog->Save();
        $class = "success";
        $result = "Publicação adicionada!";
     }catch(Exception $e){
        $class = "danger";
        $result = $e->getMessage();
     }
     echo \Extensions\Messages::Message($class, $result);
}
?>
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="preview">Pré-visualização</label>
                    <textarea class="tmce" id="preview" name="preview"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="body">Conteúdo</label>
                    <textarea class="tmce" id="body" style="height:300px;" name="body"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
            <h2 class="page-header">Informações adicionais</h2>
                <div class="form-group">
                    <label>Data/Hora da publicação</label>
                    <br>
                    <input type="text" name="timestamp" class="datetime form-control" value="<?php echo date("Y-m-d H:i");?>" data-format="YYYY-MM-DD HH:mm">
                </div>
                
                <div class="form-group" id="divtags">
                    <label for="tags">Tags</label>
                    <input type="text" name="tags" id="tags">
                </div>
                
                <div class="form-group">
                    <label>Conteúdo da tag &lt;head&gt;</label>
                    <textarea name="head" class="form-control" placeholder="(Opcional) você pode inserir tags &lt;meta&gt; aqui"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Categoria</label>
<?php
$categories = new Model\Categories();
$list = $categories->getAll();
usort($list, 'orderbyparent');
function orderbyparent($a, $b){
    return $a->getParent() > $b->getParent();
}
usort($list, 'orderbyid');
function orderbyid($a, $b){
    return $a->getId() > $b->getId();
}
foreach($list as $category){
?>
					<div class="radio recursive" data-parent="<?php echo $category->getParent();?>" data-id="<?php echo $category->getId();?>">
                        <label>
                            <input type="radio" name="category" value="<?php echo $category->getId();?>">
                            <?php echo $category->getTitle();?> <i class="fa fa-circle-o"></i>
                        </label>
                    </div>
<?php
}
?>
                </div>              
                
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success">Publicar</button>
            </div>
        </fieldset>
    </form>
</div>