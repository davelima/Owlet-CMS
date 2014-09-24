<br>
<div class="row">
    <div class="col-xs-12">
        <h1 class="text-danger text-center">Erro: módulo ou ação não encontrado</h1>
<?php
$model = ucfirst(strip_tags($_GET['model']));
$action = strip_tags($_GET['action']);
echo <<<INFO
<br>
<pre>
<b>Módulo requisitado</b>: {$model}
<b>Ação requisitada:</b> {$action}
</pre>
INFO;
?>
        <p class="text-danger text-center">Certifique-se de que o módulo existe e a requisição esteja correta</p>
    </div>
</div>