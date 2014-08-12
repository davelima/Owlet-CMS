<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Usuários" => "/admin/users/dashboard/",
    "Editar conta de usuário" => $_SERVER['REQUEST_URI']
);
require_once("inc/breadcrumbs.php");
if(!isset($_GET['id'])){
    header("Location: /admin/users/dashboard/");
    exit;
}
$users = new Model\Users();
$user = $users->getByid($_GET['id']);
?>
<h2 class="page-header">Atualizar conta de usuário</h2>
<h5>Altere os dados de um determinado usuário</h5>

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
        if(isset($_POST['password'])&&strlen($_POST['password'])){
            $users->setPassword($_POST['password']);
        }else{
            $info = $users->getById($_GET['id']);
            $users->setPassword($info->getPassword());
        }
        $users->setPhone($_POST['phone']);
        $users->setAddress($_POST['address']);
        $users->setNumber($_POST['number']);
        $users->setAddressComplement($_POST['addresscomplement']);
        $users->setNeighborhood($_POST['neighborhood']);
        $users->setCEP($_POST['cep']);
        $users->setCity($_POST['city']);
        $users->setState($_POST['state']);
        $users->setID($_GET['id']);
        $users->Save();
        $type = "success";
        $msg = "Conta atualizada com sucesso!";
        $user = $users->getById($_GET['id']);
    }catch(Exception $e){
        $type = "danger";
        $msg = $e->getMessage();
    }
    echo \Extensions\Messages::Message($type, $msg);
}
?>

                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $user->getName();?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $user->getEmail();?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Preencha para alterar">
                </div>
                
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $user->getPhone();?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="address">Endereço</label>
                    <input type="text" name="address" id="address" value="<?php echo $user->getAddress();?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="number">Nº</label>
                    <input type="text" name="number" id="number" value="<?php echo $user->getNumber();?>" class="form-control">
                </div>
            
                <div class="form-group">
                    <label for="addresscomplement">Complemento</label>
                    <input type="text" name="addresscomplement" id="addresscomplement" value="<?php echo $user->getAddressComplement();?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" name="neighborhood" id="neighborhood" value="<?php echo $user->getNeighborhood();?>" class="form-control">
                </div>
        
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" value="<?php echo $user->getCEP();?>" class="form-control">
                </div>
        
                <div class="form-group">
                    <label for="city">Cidade</label>
                    <input type="text" name="city" id="city" value="<?php echo $user->getCity();?>" class="form-control">
                </div>
        
                <div class="form-group">
                    <label for="state">Estado</label>
                    <select name="state" id="state" class="form-control">
                        <option disabled <?php echo $user->getState() ? "" : "selected";?>>Selecione um estado</option>
<?php
$states = \Extensions\Geo::$brazilianStates;
foreach($states as $uf=>$state){
    $selected = ($uf == $user->getState() ? " selected" : "");
?>
                            <option value="<?php echo $uf;?>"<?php echo $selected;?>><?php echo $state;?></option>
<?php
}
?>
                    </select>
                </div>
            </div>
    
            <div class="col-md-6 hidden-xs hidden-sm">
                <p>Atualize as informações de um usuário.</p>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </fieldset>
    </form>
</div>