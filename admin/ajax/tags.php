<?php
header("Content-Type: Application/JSON");
require_once ("../src/bootstrap.php");
$tags = new Model\Tags();
$tags = $tags->getAll();
$result = array();
foreach ($tags as $tag) {
    $result[] = $tag->getTitle();
}
print_r(json_encode(array_values($result)));