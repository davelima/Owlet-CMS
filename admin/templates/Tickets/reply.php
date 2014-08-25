<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Chamados" => "/admin/tickets/dashboard/",
    "Responder chamado" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
if (! isset($_GET['id'])) {
    header("Location: /admin/tickets/dashboard/");
    exit();
}
$tickets = new Model\Tickets();
$users = new Model\Users();
$ticket = $tickets->getById($_GET['id']);
$lastReply = $ticket->getLastReply();
$user = $users->getById($ticket->getMember());
$response = new Model\TicketResponses();

if ($_POST) {
    try {
        $response->setBody($_POST['body']);
        $response->setAdmin($_SESSION['administrator']);
        $response->setTicket($_GET['id']);
        $response->Save();
        $ticket->setStatus('waiting_user');
        $ticket->setMember($user);
        $ticket->Save();
        $type = "success";
        $message = "Resposta postada!";
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
				<h2 class="page-header">Respondendo ticket</h2>
				<div class="form-group">
					<label>Conteúdo</label>
					<textarea class="tmce" name="body" id="body"></textarea>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<select name="status" id="status" size="1" class="form-control">
						<option value="waiting_user">Aguardando resposta do usuário</option>
						<option value="waiting_admin">Aguardando resposta do administrador</option>
					</select>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-success">Responder</button>
				</div>

			</div>

			<div class="col-xs-12 col-md-4">
				<h4>Última resposta:</h4>
<?php
if ($lastReply->getBody()) {
    echo $lastReply->getAuthor()->getName() . ": <br>";
    echo $lastReply->getBody();
} else {
    echo $user->getName() . ": <br>";
    echo $ticket->getBody();
}
?>
			</div>

</div>
</fieldset>
</form>
</div>