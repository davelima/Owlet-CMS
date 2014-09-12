<?php
sleep(1);
require_once("../admin/src/bootstrap.php");
$result = array();
try{
    $database = Lib\Data::Open();
    $result['connected'] = true;
    $result['message'] = "Conectado!";
}catch(Exception $e){
    $result['connected'] = false;
    $result['message'] = $e->getMessage();
}
echo $result['message'];