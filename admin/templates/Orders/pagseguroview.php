<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Pedidos PagSeguro" => "/admin/orders/pagseguro/",
    "Detalhes do pedido" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
if (! isset($_GET['id'])) {
    header("Location: /admin/orders/pagseguro/");
    exit();
}

$order = new Model\PagSeguro\PagSeguroOrder();
$order = $order->getById($_GET['id']);
$customer = unserialize($order->getCustomer());
$items = unserialize($order->getItems());
?>


<h2 class="page-header">Pedido #<?php echo $order->getId();?> (<?php echo $order->transactionStatuses[$order->getStatus()];?>)
    <a href="<?php echo $order->getLink();?>" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-link"></i> Link de pagamento</a>
</h2>
<h3>Dados do comprador</h3>
<br>
<p><b>Nome:</b> <?php echo $customer->getName();?></p>
<p><b>E-mail:</b> <?php echo $customer->getEmail();?></p>
<p><b>Endereço:</b> <?php echo $customer->getAddress().", ".$customer->getNumber()." - ".$customer->getNeighborhood()." - ".$customer->getCEP()." - ".$customer->getCity()."/".$customer->getState();?></p>
<p><b>Telefone:</b> <?php echo "({$customer->getAreaCode()}) {$customer->getPhone()}";?></p>
<br>
<h3>Produto(s) comprado(s)</h3>
<br>
<?php
$totalAmount = 0;
foreach($items as $item){
    $subtotalAmount = number_format($item['value'] * $item['quantity'], 2, ".", "");
    $totalAmount += $subtotalAmount;
?>
<p><b><?php echo $item['quantity'];?>x</b> <?php echo $item['title'];?> - R$ <?php echo $subtotalAmount;?> (Vl. unitário: R$ <?php echo number_format($item['value'], 2, ".", "");?>)</p>
<?php
}
?>
<hr style="background:#333 !important;height:1px;">
<p><b>Valor total:</b> R$ <?php echo number_format($totalAmount, 2, ".", "");?></p>