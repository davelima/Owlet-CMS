<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Tickets" => "/admin/tickets/dashboard/",
    "Fechar ticket" => "#"
);
require_once ("inc/breadcrumbs.php");
?>

<h2 class="page-header">Tickets</h2>

<?php
if (isset($_GET['id'])) {
    try {
        $tickets = new Model\Tickets();
        $tickets = $tickets->getById($_GET['id']);
        $tickets->Close();
        $resultado = "Ticket fechado com sucesso!";
    } catch (Exception $e) {
        $resultado = $e->getMessage();
    }
    echo <<<RESULT
<script type="text/javascript">
alert("$resultado", function(){
   location.href="tickets/dashboard/";
});
</script>
RESULT;
}
?>