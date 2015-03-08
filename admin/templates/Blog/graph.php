<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/",
    "Analytics" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
if (! isset($_GET['id'])) {
    header("Location: /admin/blog/dashboard/");
    exit();
}

$blog = new Model\Blog();
$id = intval($_GET['id']);
$post = $blog->getById($id);
$today = new DateTime();

$postDate = $post->getTimestamp();

$diff = $today->diff($postDate);

if ($diff->days > 30) {
    $initDate = new DateTime();
    $initDate->modify('-1 month');
} else {
    $initDate = clone $postDate;
}

$postDate->modify('+1 day');

if ($today <= $postDate) {
    ?>
<script type="text/javascript">
alert("Ainda não existem dados disponíveis para este post. Volte mais tarde!", function(){
    location.href = '/blog/dashboard/';
});
</script>
<?php
}
?>

<h2 class="page-header">Visualizações de página do post</h2>

<br>

<div class="well">
	<h3>Informações</h3>
	<br>
	<p>
		<b>Post:</b>
		<a href="<?php echo "blog/edit/" . $post->getId() . "/";?>" target="_blank"><?php echo $post->getTitle();?> <i class="fa fa-external-link"></i>
		</a>
	</p>
	<p>
		<b>Publicado em:</b> <?php echo $post->getTimestamp()->format("d/m/Y H:i");?>
	</p>
	<p>
	   <b>Total de visualizações desde a publicação:</b> <?php echo $post->getViews($post->getTimestamp, new DateTime(), false);?>
	</p>
</div>

<br>

<div style="width: 100%">
	<div>
		<canvas id="linechart" height="200" width="600"></canvas>
	</div>
</div>

<form>
	<input type="hidden" name="id" value="<?php echo $post->getId();?>">
	<div class="row">
		<div class="col-xs-4">
			<div class="form-group">
				<label>Data de início</label>
				<br>
				<input type="date" class="datetime" name="initdate" value="<?php echo $initDate->format('Y-m-d H:i');?>">
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				<label>Data final</label>
				<br>
				<input type="date" class="datetime" name="finaldate" value="<?php echo date("Y-m-d H:i");?>">
			</div>
		</div>
		<div class="col-xs-4"></div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<a href="#" class="btn btn-success" id="updatePostGraph">Atualizar dados</a>
		</div>
	</div>

</form>

<script type="text/javascript">
$(document).ready(function() {
    $('#updatePostGraph').click();
});
</script>