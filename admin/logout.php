<?php
require_once("src/bootstrap.php");
$admin = new Model\Administrators();
$admin->killSession();
header("Location: /admin/login/");