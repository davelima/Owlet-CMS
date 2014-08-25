<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Categorias do blog" => "/admin/categories/dashboard/",
    "Atualizar categoria" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
if (! isset($_GET['id'])) {
    header("Location: /admin/categories/dashboard/");
    exit();
}
$categories = new Model\Categories();
$info = $categories->getById($_GET['id']);
?>

<div class="row">
	<form method="post" accept-charset="utf-8">
		<fieldset>
			<div class="col-xs-12 col-md-8">
				<h2 class="page-header">Atualizar categoria do blog</h2>
<?php
if ($_POST) {
    try {
        $categories->setTitle($_POST['title']);
        $_POST['parent'] = (isset($_POST['parent']) ? $_POST['parent'] : null);
        $categories->setParent($_POST['parent']);
        $categories->setId($_GET['id']);
        $categories->Save();
        $class = "success";
        $result = "Categoria atualizada com sucesso!";
        $info = $categories->getById($_GET['id']);
    } catch (Exception $e) {
        $class = "danger";
        $result = $e->getMessage();
    }
    echo \Extensions\Messages::Message($class, $result);
}
?>
                <div clas="form-group">
					<label for="title">Título da categoria</label>
					<input type="text" name="title" id="title" class="form-control" value="<?php echo $info->getTitle();?>" required>
				</div>
				<br>
				<div class="form-group">
					<button type="submit" class="btn btn-success">Atualizar</button>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<h2 class="page-header">Categoria pai</h2>
<?php
$list = $categories->getAll();
usort($list, 'orderbyparent');

function orderbyparent($a, $b)
{
    return $a->getParent() > $b->getParent();
}
foreach ($list as $category) {
    if ($category->getId() == $info->getId())
        continue;
    ?>
					<div class="radio recursive" data-parent="<?php echo $category->getParent();?>" data-id="<?php echo $category->getId();?>">
					<label>
						<input type="radio" name="parent" value="<?php echo $category->getId();?>" <?php echo ($category->getId() == $info->getParent() ? " checked" : "");?>>
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