<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Chamados" => "/admin/tickets/dashboard/",
    "Criar chamado" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
$tickets = new Model\Tickets();
$users = new Model\Users();

if ($_POST) {
    try {
        $user = $users->getById($_POST['member']);
        $tickets->setMember($user);
        $tickets->setTitle($_POST['title']);
        $tickets->setBody($_POST['body']);
        $tickets->setStatus($_POST['status']);
        $tickets->Save();
        $type = "success";
        $message = "Ticket criado com sucesso!";
    } catch (Exception $e) {
        $type = "danger";
        $message = $e->getMessage();
    }
    
    echo Extensions\Messages::Message($type, $message);
}
?>

<div class="row">
	<form method="post" accept-charset="utf-8">
		<fieldset>
			<div class="col-xs-12 col-md-8">
				<h2 class="page-header">Novo ticket</h2>
				<h5>Crie um novo ticket</h5>
				<div class="form-group">
					<label for="title">Título</label>
					<input type="text" name="title" id="title" class="form-control">
				</div>
				<div class="form-group">
					<label>Conteúdo</label>
					<textarea class="tmce" name="body" id="body"></textarea>
				</div>
				<div class="form-group">
					<label for="member">Usuário</label>
					<select name="member" id="member" size="1" class="form-control">
						<option disabled selected>Escolha um usuário</option>
<?php
$allUsers = $users->getAll();
foreach ($allUsers as $user) {
    ?>
                        <option value="<?php echo $user->getId();?>"><?php echo $user->getName()." ({$user->getEmail()})"?></option>
<?php
}
?>
                    </select>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<select name="status" id="status" size="1" class="form-control">
						<option value="waiting_admin">Aguardando resposta do administrador</option>
						<option value="waiting_user">Aguardando resposta do usuário</option>
					</select>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-success">Criar ticket</button>
				</div>

			</div>

</div>
</fieldset>
</form>
</div>