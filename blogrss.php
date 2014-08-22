<?php
header("Content-Type: text/xml");
require_once("admin/src/bootstrap.php");
$blog = new Model\Blog();
echo $blog->getRSS();