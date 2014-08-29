<?php
header("Content-Type: Application/JSON");
require_once ("../src/bootstrap.php");


if(isset($_GET['cep'])){
    $result = \Extensions\CEP::Get($_GET['cep']);
}else{
    $result = array(
        "INVALID_QUERY"
    );
}

print_r(json_encode($result));