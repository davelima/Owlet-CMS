<?php
require_once ("admin/src/bootstrap.php");
if (isset($_POST['notificationCode']) && isset($_POST['notificationType'])) {
    $PagSeguroOrder = new Model\PagSeguro\PagSeguroOrder();
    $PagSeguroOrder->checkNotification($_POST['notificationCode']);
}