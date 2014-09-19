<?php
require_once ("../admin/src/bootstrap.php");
header("Content-Type: Application/JSON");
$result = array(
    "status" => 200,
    "statusText" => "OK"
);

$database = Lib\Data::Open();

switch (Lib\Data::$dbms) {
    case "pgsql":
        $sql = file_get_contents("database/pgsql.sql");
        break;
    default:
    case "mysql":
        $sql = file_get_contents("database/mysql.sql");
        break;
}

try {
    Lib\Data::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    Lib\Data::$db->exec($sql);
    $administrator = new Model\Administrators();
    $administrator->setName($_POST['name']);
    $administrator->setEmail($_POST['email']);
    $administrator->setPassword($_POST['password']);
    $administrator->setUserName($_POST['username']);
    $administrator->setRoot(true);
    $administrator->Save();
    
    $config = Extensions\Config::get();
    $config->title = $_POST['title'];
    $config->blog->blogName = $_POST['title'];
    $config->blog->sendNotificationToMailing = 0;
    $config->tickets->title = $_POST['title'];
    
    $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];
    $config->mailing->confirmationURL = $baseUrl . "/confirmemail.php";
    $config->mailing->cancelURL = $baseUrl . "/cancelemail.php";
    
    \Extensions\Config::Save();
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    $result["status"] = 500;
    $result["statusText"] = $e->getMessage();
}
print_r(json_encode($result));