<?php
$mailer = new Extensions\Mailer();

$mailer->recipient = array(
    "email" => "david.lima@agenciayep.com",
    "name" => "Fulano de tal"
);

$mailer->subject = "Hello World";
$mailer->message = "Alô!";

$mailer->Send();