<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Usuários" => "/admin/users/dashboard/",
);
require_once("inc/breadcrumbs.php");
$users = new Model\Users();
?>

<h2 class="page-header">Usuários</h2>

<table class="table">
    <thead>
        <th scope="col">Nome</th>
        <th scope="col">E-mail</th>
        <th scope="col" style="width:50px;"></th>
    </thead>
    <tbody>
<?php
$list = $users->getAll();
foreach($list as $user){
?>
        <tr>
            <td><?php echo $user->getName();?></td>
            <td><?php echo $user->getEmail();?></td>
            <td>
                <a href="users/edit/<?php echo $user->getId();?>/"><i class="fa fa-pencil"></i></a>
                <a href="users/delete/<?php echo $user->getId();?>/" class="delete" data-confirm="Deseja realmente apagar esta conta de usuário?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>