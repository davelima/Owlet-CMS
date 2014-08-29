<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Pagamentos" => $_SERVER['REQUEST_URI'],
    "Novo pedido do PagSeguro" => $_SERVER['REQUEST_URI']
);

require_once ("inc/breadcrumbs.php");

?>

<div class="row">
	<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<fieldset>
			<div class="col-xs-12 col-md-8">
<?php
if ($_POST) {
    try {
        $customer = new Model\PagSeguro\PagSeguroCustomer();
        $pagseguro = new Model\PagSeguro\PagSeguroOrder();
        
        $itens = array(
            array(
                "id" => $_POST['productCode'],
                "title" => $_POST['productName'],
                "quantity" => $_POST['productQuantity'],
                "value" => $_POST['productAmount']
            )
        );
        
        $_POST['phone'] = preg_replace("([^0-9])", "", $_POST['phone']);
        $areaCode = substr($_POST['phone'], 0, 2);
        $phone = substr($_POST['phone'], 2);
        $customer->setName($_POST['name']);
        $customer->setEmail($_POST['email']);
        $customer->setAreaCode($areaCode);
        $customer->setPhone($phone);
        $customer->setCEP($_POST['cep']);
        $customer->setAddress($_POST['address']);
        $customer->setNumber($_POST['number']);
        $customer->setNeighborhood($_POST['neighborhood']);
        $customer->setAddressComplement(null);
        $customer->setCity($_POST['city']);
        $customer->setState($_POST['state']);
        $customer->setCountry("BRA");
        
        $pagseguro->setCustomer($customer);
        $pagseguro->setItems($itens);
        if (isset($_POST['description'])) {
            $pagseguro->setDescription($_POST['description']);
        }
        $type = "success";
        $message = "Link criado com sucesso!";
        $url = $pagseguro->getPaymentLink();
        $pagseguro->setLink($url);
        $pagseguro->Save();
        
        $config = \Extensions\Config::get();
        $config = $config->mailer;
        
        if (isset($config->sender)) {
            $order = $pagseguro->get("", "timestamp DESC, id", 1);
            if (count($order)) {
                $order = $order[0];
                $mailer = new Extensions\Mailer();
                $mailer->subject = "Pedido #{$order->getId()} efetuado com sucesso";
                $totalAmount = number_format($_POST['productAmount'] * $_POST['productQuantity'], 2, ".", "");
                $mailer->message = <<<BODY
<p>Olá, {$_POST['name']}, seu pedido de {$_POST['productQuantity']} {$_POST['productName']} no valor de R$ {$_POST['productAmount']} foi efetuado com sucesso.</p>
<p>Número do pedido: {$order->getId()}</p>
<p>Valor total: R$ {$totalAmount}</p>
<p>Utilize o link abaixo para realizar o pagamento do seu pedido!</p>
<p><a href="$url" target="_blank">Realizar pagamento agora</a></p>         
BODY;
                if(isset($_POST['description'])){
                    $mailer->message .= <<<DESCRIPTION
<h4>Informações adicionais</h4>
{$_POST['description']}
DESCRIPTION;
                }
                $mailer->recipient = array(
                    "name" => $_POST['name'],
                    "email" => $_POST['email']
                );
                $mailer->Send();
            }
        }
    } catch (Exception $e) {
        $type = "danger";
        $message = $e->getMessage();
    }
    echo Extensions\Messages::Message($type, $message);
}
?>
				<h2 class="page-header">Novo pedido do PagSeguro</h2>
				<h5>Preencha o formulário para gerar um novo link de pagamento</h5>

				<div class="form-group">
					<label for="productCode">Código do produto</label>
					<input type="text" name="productCode" id="productCode" class="form-control number" required>
				</div>

				<div class="form-group">
					<label for="productName">Nome do produto</label>
					<input type="text" name="productName" id="productName" class="form-control" required>
				</div>

				<div class="form-group">
					<label for="productAmount">Valor do produto (R$)</label>
					<input type="text" name="productAmount" id="productAmount" class="form-control mask" data-mask="000000000.00" data-reverse="true" required>
				</div>

				<div class="form-group">
					<label for="productQuantity">Quantidade de produtos</label>
					<input type="text" name="productQuantity" id="productQuantity" class="form-control number" required>
				</div>

				<div class="form-group">
					<label for="email">E-mail de cobrança</label>
					<input type="email" name="email" id="email" class="order-emailtrigger form-control" required>
				</div>

				<div class="form-group">
					<label for="name">Nome</label>
					<input type="text" name="name" id="name" class="form-control" required>
				</div>

				<div class="form-group">
					<label for="phone">Telefone</label>
					<input type="text" name="phone" id="phone" class="form-control phone mask" data-mask="CelSP" required>
				</div>

				<div class="form-group">
					<label for="cep">CEP</label>
					<input type="text" name="cep" id="cep" class="form-control cep cep-trigger" required>
				</div>


				<div class="form-group">
					<label for="address">Endereço de cobrança</label>
					<input type="text" name="address" id="address" class="form-control" required>
				</div>

				<div class="form-group">
					<label for="number">Número</label>
					<input type="text" name="number" id="number" class="form-control number" required>
				</div>

				<div class="form-group">
					<label for="neighborhood">Bairro</label>
					<input type="text" name="neighborhood" id="neighborhood" class="form-control" required>
				</div>

				<div class="form-group">
					<label for="city">Cidade</label>
					<input type="text" name="city" id="city" class="form-control" required>
				</div>

				<div class="form-group">
					<label for="state">Estado</label>
					<select name="state" id="state" size="1" class="form-control" required>
						<option disabled selected>Escolha um estado</option>
<?php
foreach (\Extensions\Geo::$brazilianStates as $acronym => $state) {
    ?>
                            <option value="<?php echo $acronym;?>"><?php echo $state;?></option>
<?php
}
?>
				    </select>
				</div>

				<div class="form-group">
					<label>Informações adicionais</label>
					<textarea class="tmce" rows="5" cols="5" name="description"></textarea>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-success">Gerar pedido</button>
				</div>



			</div>
		</fieldset>
	</form>
</div>


<?php

?>