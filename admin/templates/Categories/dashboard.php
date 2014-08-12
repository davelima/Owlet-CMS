<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Categorias do blog" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");
$categories = new Model\Categories();
?>

<h2 class="page-header">Categorias do blog</h2>

<table class="table">
    <thead>
        <th scope="col">Título</th>
        <th scope="col">Categoria-pai</th>
        <th scope="col" style="width:50px;"></th>
    </thead>
    <tbody>
<?php
$list = $categories->getAll();
usort($list, 'orderbyparent');
function orderbyparent($a, $b){
    return $a->getParent() > $b->getParent();
}
foreach($list as $category){
    if($category->getParent()){
        $category->setParent($category->getById($category->getParent()));
        $parentTitle = $category->getParent()->getTitle();
    }else{
        $parentTitle = "";
    }
?>
        <tr>
            <td><?php echo $category->getTitle();?></td>
            <td><?php echo $parentTitle;?></td>
            <td>
                <a href="categories/edit/<?php echo $category->getId();?>/" title="Editar"><i class="fa fa-pencil"></i></a>
                <a href="categories/delete/<?php echo $category->getId();?>/" title="Apagar" class="delete" data-confirm="Deseja realmente apagar esta categoria e todas as suas categorias dependentes?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>