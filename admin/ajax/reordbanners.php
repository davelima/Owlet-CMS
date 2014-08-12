<?php
require_once("../src/bootstrap.php");
if($_POST){
    if(isset($_POST['id'])&&isset($_POST['position'])){
        $banner = new Model\Banners();
        $id = intval($_POST['id']);
        $position = intval($_POST['position']);
        $banner = $banner->getById($id);
        $banner->setPosition($position);
        $banner->Save();
    }
}