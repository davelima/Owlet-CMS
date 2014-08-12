<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Comentários" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$comments = new Model\Comments();
$post = new Model\Blog();
if(isset($_GET['id'])){
    $list = $comments->getByColumn("post", $_GET['id']);
}else{
    $list = $comments->getAll();
}
?>

<h2 class="page-header">Comentários do blog</h2>

<table class="table">
	<thead>
		<th scope="col">Comentário</th>
		<th scope="col">Publicação</th>
		<th scope="col" style="width: 150px;">Data</th>
		<th scope="col" style="width: 70px;"></th>
	</thead>
	<tbody>
<?php
foreach($list as $comment){
?>
        <tr>
            <td><?php echo $comment->getBody();?></td>
            <td><?php echo $comment->getPost()->getTitle();?></td>
            <td><?php echo $comment->getTimestamp()->format('d/m/Y H:i');?></td>
            <td>
                <a href="blog/replycomment/<?php echo $comment->getId();?>/"><i class="fa fa-reply"></i></a>
                <a href="blog/deletecomment/<?php echo $comment->getId();?>/" class="delete" data-confirm="Deseja realmente apagar este comentário?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
	</tbody>
</table>