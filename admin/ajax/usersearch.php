<?php
header("Content-Type: Application/JSON");
require_once ("../src/bootstrap.php");
$result = array(
    "result" => "NOT_FOUND"
);
if (isset($_GET['email'])) {
    if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        $user = new Model\Users();
        $user = $user->getByColumn("email", $_GET['email']);
        if (count($user)) {
            $result['result'] = $user[0]->getData();
        }
    }
}

print_r(json_encode($result));