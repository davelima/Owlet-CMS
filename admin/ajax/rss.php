<?php
header("Content-Type: Application/JSON");
require_once ("../src/bootstrap.php");
$simplepie = new Extensions\SimplePie\SimplePie();

if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
    $limit = $_GET['limit'];
} else {
    $limit = 5;
}

$rss = new Model\RSS();
$result = $rss->getFeed($limit);

print_r(json_encode($result));