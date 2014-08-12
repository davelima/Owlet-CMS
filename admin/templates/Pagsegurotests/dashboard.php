<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Testes do PagSeguro" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");

$pagseguro = new Model\PagSeguro\PagSeguroOrder();
$customer = new Model\PagSeguro\PagSeguroCustomer();

$customer->setName("Fulano de tal");
$customer->setEmail("fulano@fulanodetal.com.br");
$customer->setAreaCode("11");
$customer->setPhone("23114555");
$customer->setCEP("09131280");
$customer->setAddress("Av. Goiás");
$customer->setNumber(269);
$customer->setAddressComplement(null);
$customer->setNeighborhood("Centro");
$customer->setCity("São Caetano do Sul");
$customer->setState("SP");
$customer->setCountry("BRA");
$customer->setId(1);

$pagseguro->setCustomer($customer);

$itens = array(
    array(
        "id" => 1,
        "title" => "Produto de teste",
        "quantity" => 1,
        "value" => 150.57
    )
);

$pagseguro->setItems($itens);
echo $pagseguro->getPaymentLink();
?>