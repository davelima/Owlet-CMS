<?php
require_once("src/bootstrap.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once("inc/head.php");
?>
</head>
<body>
	<!--Start Header-->
	<div id="screensaver">
		<canvas id="canvas"></canvas>
		<i class="fa fa-lock" id="screen_unlock"></i>
	</div>
	<header class="navbar">
<?php
require_once("inc/header.php");
?>
	</header>
	<!--End Header-->
	<!--Start Container-->
	<div id="main" class="container-fluid">
		<div class="row">
			<div id="sidebar-left" class="col-xs-2 col-sm-2">
<?php
require_once("inc/sidebar.php");
?>
			</div>
			<!--Start Content-->
			<div id="content" class="col-xs-12 col-sm-10">
				<div id="ajax-content">
<?php
				new Controller\Controller();
?>
				</div>
			</div>
			<!--End Content-->
		</div>
	</div>
<?php
require_once("inc/foot.php");
?>
</body>
</html>