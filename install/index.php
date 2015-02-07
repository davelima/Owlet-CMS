<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Configurador do CMS</title>
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="../admin/plugins/bootstrap/bootstrap.min.js"></script>
<link href="../admin/plugins/bootstrap//bootstrap.min.css" rel="stylesheet">
<script src="src/bootstrap-wizard.min.js"></script>
<link href="src/bootstrap-wizard.css" rel="stylesheet">
</head>
<body>
	<div class="wizard" id="some-wizard" data-title="Configuração do sistema">

		<div class="wizard-card" data-cardname="permissions">
			<h3>Arquivos e permissões</h3>
			<h5>
				<a href="#" id="testpermissions" class="btn btn-info">
					<i class="fa fa-refresh"></i>
					Verificar
				</a>
			</h5>
			<div>
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Arquivo</th>
							<th scope="col">Permissões</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<b>admin/config.xml</b>
							</td>
							<td>
								<span id="config-xml">Não verificado</span>
							</td>
						</tr>
						<tr id="databasecheck">
							<td>
								<b>database/<span id="dbdriver"></span></b>
							</td>
							<td>
								<span id="dbdriverfile">Não verificado</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="wizard-card" data-cardname="database">
			<h3>Teste do banco de dados</h3>
			<h5>
				<a href="#" id="updatedatabasestatus" class="btn btn-info">
					<i class="fa fa-refresh"></i>
					Verificar conexão
				</a>
			</h5>
			<div class="alert" id="databasestatus">Conexão não disponível</div>
		</div>

		<div class="wizard-card" data-cardname="systemdata">
			<h3>Preferências do sistema</h3>

			<div class="form-group">
				<label for="title">Título do website</label>
				<input type="text" name="title" id="title" title="Título do website" class="form-control" value="Admin">
			</div>
		</div>

		<div class="wizard-card" data-cardname="userdata" data-validate="validateAdministratorData">
			<h3>Dados do administrador</h3>
			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text" name="name" id="name" class="form-control" title="Nome" required>
			</div>

			<div class="form-group">
				<label for="email">E-mail</label>
				<input type="email" name="email" id="email" class="form-control" title="E-mail" required>
			</div>

			<div class="form-group">
				<label for="username">Login</label>
				<input type="text" name="username" id="username" class="form-control" title="Login" required>
			</div>

			<div class="form-group">
				<label for="password">Senha</label>
				<input type="password" name="password" id="password" class="form-control" title="Senha" required>
			</div>
		</div>

		<div class="wizard-card" data-cardname="emailsetup">
			<h3>Configuração de e-mail (SMTP)</h3>
			<div class="form-group">
				<label for="emailaccount">Conta</label>
				<input type="email" name="emailaccount" id="emailaccount" class="form-control" title="Conta de e-mail">
			</div>

			<div class="form-group">
				<label for="emailhost">Servidor SMTP</label>
				<input type="text" name="emailhost" id="emailhost" class="form-control" title="Servidor SMTP">
			</div>

			<div class="form-group">
				<label for="emailpassword">Senha do e-mail</label>
				<input type="password" name="emailpassword" id="emailpassword" class="form-control" title="Senha do e-mail">
			</div>

			<div class="form-group">
				<label for="emailauth">Tipo de autenticação do e-mail</label>
				<select name="emailauth" id="emailauth" class="form-control">
					<option value="ssl">SSL</option>
					<option value="tls">TLS</option>
				</select>
			</div>

			<div class="form-group">
				<label for="emailport">Porta de saída</label>
				<input type="number" name="emailport" id="emailport" class="form-control" title="Porta de saída de e-mails">
			</div>

			<div class="form-group">
				<button type="button" class="btn btn-info" id="testemail">
					<i class="fa fa-envelope"></i>
					Salvar e enviar e-mail de teste
				</button>
				<p id="emailteststatus"></p>
			</div>

		</div>

		<div class="wizard-success">
			<div class="alert alert-success">Sistema configurado com sucesso! Clique no botão abaixo para fazer login no sistema.</div>
			<a href="/admin/logout/" class="btn btn-success">Página de login</a>
		</div>

		<div class="wizard-error">
			<div class="alert alert-danger">Ocorreu um erro durante a configuração do sistema. Por favor, reinicie a configuração.</div>
			<a href="index.php" class="btn btn-danger">Reiniciar configuração</a>
		</div>

		<div class="wizard-failure">
			<div class="alert alert-warning">Um erro interno no servidor impediu que a configuração do sistema fosse concluída.</div>
		</div>

	</div>
</body>
<script>


function validateAdministratorData(card){
$('.popover').remove();
  var inputs = card.el.find('input[required]'),
  errors = 0;
  $.each(inputs, function(i, obj){
    console.log($(obj).val());
    if(!$(obj).val()){
      card.wizard.errorPopover($(obj), "Preencha este campo!");
      errors++;
      }
  });
  if(errors){
    return false;
  }else{
    return true;
  }
};

$(document).ready(function(){
    var wizard = $('#some-wizard').wizard({
    	keyboard : true,
    	contentHeight : 700,
    	contentWidth : $(window).width()-200,
    	backdrop: 'static',
    	submitUrl: "setup.php"
    });
    wizard.show();
    

    $('#testemail').on('click', function(){
      var button = $(this);

      $.ajax({
        url: "testemail.php",
        type: "POST",
        data:{
          emailaccount: $('#emailaccount').val(),
          name: $('#name').val(),
          emailhost: $('#emailhost').val(),
          emailport: $('#emailport').val(),
          emailauth: $('#emailauth').val(),
          emailpassword: $('#emailpassword').val()
        },
        beforeSend: function(){
          $('body').css('cursor', 'progress');
          $('#emailteststatus').empty();
        },
        complete: function(){
          $('body').css('cursor', '');
          $('#emailteststatus').html("<p>Uma mensagem foi enviada para o e-mail informado. Se você não recebeu o e-mail, verifique as configurações acima.</p>");
        }
      });
    });

    $('#updatedatabasestatus').on('click', function(){
      var button = $(this),
      alert = $('#databasestatus');
      $.ajax({
        url: "testconnection.php",
        beforeSend: function(){
          $('body').css('cursor', 'progress');
          button.find('i').addClass('fa-spin');
          $('#message').remove();
        },
        complete: function(){
          $('body').css('cursor', '');
          button.find('i').removeClass('fa-spin');
        },
        success: function(data){
          alert.html(data);
          if(data=="Conectado!"){
            alert.addClass('alert-success').removeClass('alert-danger');
            wizard.showButtons();
          }else{
            alert.addClass('alert-danger').removeClass('alert-success');
            $('<p id="message">Corrija os erros acima e clique em "Verificar conexão". A configuração só pode continuar quando houver uma conexão válida com seu banco de dados.</p>').insertAfter(alert);
            wizard.hideButtons();
          }
        }
      });
    });
    

    $('#testpermissions').on('click', function(e){
        e.preventDefault();
        var button = $(this),
        icon = $(this).find('i');
        $.ajax({
            url: "testpermissions.php",
            type: "GET",
            dataType: "JSON",
            beforeSend: function(){
                icon.addClass("fa-spin");
                button.attr('disabled', true);
            },
            complete: function(){
                icon.removeClass("fa-spin");
                button.attr('disabled', false);
            },
            success: function(data){
                $('#dbdriver').html(data.dbdriver);
                var permErrors = 0;
                $.each(data, function(i, obj){
                    if(obj.hasOwnProperty("perms")){
                        if(!obj.perms){
                            $('#'+obj.id).removeClass('text-success');
                            $('#'+obj.id).addClass('text-danger').html("Precisa de permissão para escrita e leitura!");
                            permErrors++;
                            console.error('deu erro');
                            console.log(obj);
                        }else{
                            $('#'+obj.id).removeClass('text-danger');
                            $('#'+obj.id).addClass('text-success').html('OK!');
                        }
                    }
                });

                console.log(permErrors);
                
                if(permErrors > 0){
                    wizard.hideButtons();
                }else{
                    wizard.showButtons();
                }
        
            }
        });
    });
    
    $('#updatedatabasestatus, #testpermissions').click();
});

</script>
</html>