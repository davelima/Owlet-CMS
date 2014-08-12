<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Administradores" => "/admin/administrators/dashboard/"
);
require_once("inc/breadcrumbs.php");
$admin = new Model\Administrators();
if(!$admin->isRoot()){
    header("Location: /admin/dashboard/");
    exit;
}
?>

<h2 class="page-header">Administradores</h2>

<table class="table">
    <thead>
        <th scope="col">Nome</th>
        <th scope="col">Login</th>
        <th scope="col" style="width:50px;"></th>
    </thead>
    <tbody>

<?php
$administrators = $admin->getAll();
foreach($administrators as $user){
?>
        <tr>
            <td><?php echo ($user->getRoot() ? '<i class="fa fa-star" title="Administrador geral"></i> ' : "");?><?php echo $user->getName();?></td>
            <td><?php echo $user->getUserName();?></td>
            <td>
                <a href="administrators/edit/<?php echo $user->getId();?>/" title="Editar"><i class="fa fa-pencil"></i></a>
                <a href="administrators/delete/<?php echo $user->getId();?>/" title="Apagar" class="delete" data-confirm="Deseja realmente apagar esta conta de administrador?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>