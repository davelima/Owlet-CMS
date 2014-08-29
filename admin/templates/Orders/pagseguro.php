<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Pedidos PagSeguro" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$pagseguro = new Model\PagSeguro\PagSeguroOrder();
?>

<h2 class="page-header">Pedidos PagSeguro</h2>

<table class="table">
	<thead>
		<tr>
			<th scope="col">Produto(s)</th>
			<th scope="col" style="width: 100px;">Vl. Total</th>
			<th scope="col">Comprador</th>
			<th scope="col">Status</th>
			<th scope="col" style="width: 24px;"></th>
		</tr>
	</thead>
	<tbody>
<?php
$orders = $pagseguro->getAll();
foreach ($orders as $order) {
    $info = $order->getOrderInfo();
    ?>
    <tr>
			<td><?php echo $info['items'];?></td>
			<td><?php echo $info['amount'];?></td>
			<td><?php echo $info['customer']->getName();?></td>
			<td><?php echo $pagseguro->transactionStatuses[$order->getStatus()];?></td>
			<td>
				<a href="orders/pagseguroview/<?php echo $order->getId();?>/">
					<i class="fa fa-eye"></i>
				</a>
			</td>
		</tr>
<?php
}
?>
	</tbody>
</table>