<?php
$mailing = new Model\Mailing();
$emails = array(
    "david.lima@agenciayep.com",
    "arnaldo.mendes@agenciayep.com",
    "nilton.oliveira@agenciayep.com",
    "andre.sales@agenciayep.com.br",
    "carlos.henrique@agenciayep.com",
    "renan.barbosa@agenciayep.com",
    "eduardo.paulino@agenciayep.com.br",
    "mayara.bizzi@agenciayep.com.br",
    "debora.correia@agenciayep.com",
    "andre.luis@agenciayep.com.br",
    "andre.coimbra@agenciayep.com.br"
);

foreach($emails as $email){
    $mailing->setEmail($email);
    $mailing->Save();
    echo $email."OK<br>";
}