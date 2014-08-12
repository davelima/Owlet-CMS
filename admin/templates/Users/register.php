<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Usuários" => "/admin/users/dashboard/",
);
require_once("inc/breadcrumbs.php");
$users = new Model\Users();
?>
<h2 class="page-header">Registrar novo usuário</h2>
<h5>Cadastre um novo usuário no seu site</h5>

<div class="row">
    <form method="post" accept-charset="utf-8">
        <fieldset>
            <div class="col-xs-12 col-md-6">
<?php
if($_POST){
    try{
        $fields = array("name", "email", "password", "phone", "address", "number", "addresscomplement", "neighborhood", "cep", "city", "state");
        foreach($fields as $field){
            if(!isset($_POST[$field])){
                $_POST[$field] = null;
            }
        }
        $users->setName($_POST['name']);
        $users->setEmail($_POST['email']);
        $users->setPassword($_POST['password']);
        $users->setPhone($_POST['phone']);
        $users->setAddress($_POST['address']);
        $users->setNumber($_POST['number']);
        $users->setAddressComplement($_POST['addresscomplement']);
        $users->setNeighborhood($_POST['neighborhood']);
        $users->setCEP($_POST['cep']);
        $users->setCity($_POST['city']);
        $users->setState($_POST['state']);
        $users->Save();
        $type = "success";
        $msg = "Usuário cadastrado com sucesso!";
    }catch(Exception $e){
        $type = "danger";
        $msg = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $msg);
}
?>

                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha *</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="address">Endereço</label>
                    <input type="text" name="address" id="address" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="number">Nº</label>
                    <input type="text" name="number" id="number" class="form-control">
                </div>
            
                <div class="form-group">
                    <label for="addresscomplement">Complemento</label>
                    <input type="text" name="addresscomplement" id="addresscomplement" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" name="neighborhood" id="neighborhood" class="form-control">
                </div>
        
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control">
                </div>
        
                <div class="form-group">
                    <label for="city">Cidade</label>
                    <input type="text" name="city" id="city" class="form-control">
                </div>
        
                <div class="form-group">
                    <label for="state">Estado</label>
                    <select name="state" id="state" class="form-control">
                        <option disabled selected>Selecione um estado</option>
<?php
$states = \Extensions\Geo::$brazilianStates;
foreach($states as $uf=>$state){
?>
                            <option value="<?php echo $uf;?>"><?php echo $state;?></option>
<?php
}
?>
                    </select>
                </div>
                  <!--</fieldset>
                </form>-->
            </div>
    
            <div class="col-md-6 hidden-xs hidden-sm">
                <p>Você pode criar uma nova conta de usuário a partir deste formulário.</p>
                <p>Assim que você efetuar o cadastro, o usuário receberá, no e-mail registrado, uma mensagem com os dados de acesso.</p>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success">Registrar</button>
            </div>
        </fieldset>
    </form>
</div>