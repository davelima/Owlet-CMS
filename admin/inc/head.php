<meta charset="utf-8">
<base href="/<?php echo basename(getcwd());?>/">
<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
<link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
<link href="plugins/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
<link href="plugins/select2/select2.css" rel="stylesheet">
<link href="plugins/tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
<link href="plugins/stepper/jquery.fs.stepper.css" rel="stylesheet">
<link href="plugins/jqueryui/jquery-ui.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/typeahead/typeahead.js"></script>
<script src="plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="plugins/tinymce/jquery.tinymce.min.js"></script>
<script src="plugins/datetimepicker/jquery.datetimepicker.js"></script>
<script src="plugins/tagsinput/bootstrap-tagsinput.js"></script>
<script src="plugins/jqueryui/jquery-ui.min.js"></script>
<script src="plugins/jquerymask/jquery.mask.min.js"></script>
<script src="plugins/stepper/jquery.fs.stepper.min.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="js/devoops.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
<![endif]-->

<?php
// Theming
$themesObj = new Extensions\Themes();
$currentTheme = $themesObj->getCurrentTheme();
if ($currentTheme != "default") {
    ?>
<link href="themes/<?php echo $currentTheme;?>.css" rel="stylesheet">
<?php
}
?>