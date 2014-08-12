<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<ol class="breadcrumb">
<?php
if(!isset($breadcrumbs)){
    $breadcrumbs = array('Home' => '#');
}
foreach($breadcrumbs as $page=>$link){
?>
            <li><a href="<?php echo $link;?>"><?php echo $page;?></a></li>
<?php
}
?>
		</ol>
	</div>
</div>