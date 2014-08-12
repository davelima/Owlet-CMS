<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Categorias do blog" => "/admin/categories/dashboard/",
    "Adicionar categoria" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");
$categories = new Model\Categories();
?>

<div class="row">
    <form method="post" accept-charset="utf-8">
        <fieldset>
            <div class="col-xs-12 col-md-8">
                <h2 class="page-header">Adicionar categoria ao blog</h2>
                <h5>Crie uma nova categoria para organizar as suas publicações</h5>
<?php
if($_POST){
     try{
        $categories->setTitle($_POST['title']);
        $_POST['parent'] = (isset($_POST['parent']) ? $_POST['parent'] : null);
        $categories->setParent($_POST['parent']);
        $categories->Save();
        $class = "success";
        $result = "Categoria adicionada com sucesso!";
     }catch(Exception $e){
        $class = "danger";
        $result = $e->getMessage();
     }
     echo \Extensions\Messages::Message($class, $result);
}
?>
                <div clas="form-group">
                    <label for="title">Título da categoria</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Adicionar</button>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <h2 class="page-header">Categoria pai</h2>
<?php
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
                            <input type="radio" name="parent" value="<?php echo $category->getId();?>">
                            <?php echo $category->getTitle();?> <i class="fa fa-circle-o"></i>
                        </label>
                    </div>
<?php
}
?>
            </div>
        </fieldset>
    </form>
</div>