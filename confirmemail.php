<?php
if (isset($_GET['token']) && strlen($_GET['token']) == 40) {
    require_once ("admin/src/bootstrap.php");
    $token = $_GET['token'];
    try {
        $mailing = new Model\Mailing();
        $email = $mailing->getByColumn("token", $token);
        if (count($email)) {
            $email = $email[0];
            $email->setStatus(1);
            $email->Save();
            echo "<p>E-mail confirmado com sucesso!</p>";
        }else{
            throw new Exception("Código de verificação inválido.");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    header("Location: /");
}