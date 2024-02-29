<?php
    if(isset($_POST['submit']))
    {
        // print_r($_POST['nome']);
        // print_r($_POST['cpf']);
        // print_r($_POST['email']);
        // print_r($_POST['telefone']);
        // print_r($_POST['estado_civil']);
        // print_r($_POST['endereco']);
        // print_r($_POST['cep']);
        // print_r($_POST['data_nascimento']);

        include_once('config.php');

        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $estado_civil = $_POST['estado_civil'];
        $endereco = $_POST['endereco'];
        $cep = $_POST['cep'];
        //calcula a idade com base na data de nascimento
        $data_nascimento = $_POST['data_nascimento'];
        $data_nascimento_formatada = date("Y-m-d", strtotime($data_nascimento)); // Formata a data para o formato do MySQL
        $hoje = new DateTime();
        $idade = $hoje->diff(new DateTime($data_nascimento))->y;

        //Manda os dados para o banco
        $result = mysqli_query($conexao, "INSERT INTO usuarios(nome,cpf,email,telefone,estado_civil,endereco,cep,data_nascimento,idade) VALUES ('".$_POST['nome']."','".$_POST['cpf']."','".$_POST['email']."','".$_POST['telefone']."','".$_POST['estado_civil']."','".$_POST['endereco']."','".$_POST['cep']."','".$data_nascimento_formatada."','".$idade."')");

    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="box">
        <form action="index.php" method="POST">
            <fieldset>
                <div class="title">
                    <h1>Cadastro</h1>
                </div>
                
                <div class="forms">
                    <!--Nome Completo-->
                    <div class="inputbox">
                        <label for="nome" class="label">Nome Completo:</label>
                        <input type="text" name="nome" id="nome" class="inputUser" required>
                    </div>
                    <!--CPF-->
                    <div class="inputbox">
                        <label for="cpf" class="label">CPF:</label>
                        <input type="text" name="cpf" id="cpf" class="inputUser" required>
                        
                    </div>
                    <!--Email-->
                    <div class="inputbox">
                        <label for="email" class="label">Email:</label>
                        <input type="email" name="email" id="email" class="inputUser" required>
                        
                    </div>
                    <!--Telefone-->
                    <div class="inputbox">
                        <label for="telefone" class="label">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" class="inputUser" required>
                        <small>Formato: 13 99712-3456</small>
                    </div>
                    <!--Estado civil-->
                    <div class="inputbox">
                        <label for="estado_civil" class="label">Estado Civil:</label>
                        <select name="estado_civil" class="formatbox">
                            <option value="solteiro">Solteiro</option>
                            <option value="casado">Casado</option>
                            <option value="separado">Separado</option>
                            <option value="divorciado">Divorciado</option>
                            <option value="viuvo">Viúvo</option>
                        </select>
                    </div>
                    
                      
                    <!--Endereço-->
                    <div class="inputbox">
                        <label for="endereco" class="label">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" class="inputUser" required>
                        
                    </div>  
                    <!--CEP-->
                    <div class="inputbox">
                        <label for="cep" class="label">CEP:</label>
                        <input type="text" name="cep" id="cep" class="inputUser" required>
                        
                    </div> 
                    <div class="inputbox">
                        <!--Data de Nascimento-->
                        <label for="data_nascimento" class="label">Data de Nascimento:</label>
                        <input type="date" name="data_nascimento" class="formatbox" required>
                    </div>
                    
                    <!--Idade-->
                    <div class="inputbox">
                         <label for="idade" class="label">Idade: </label>
                         <input type="text" id="idade" name="idade" class="inputUser" value="<?php echo $idade; ?>" reandoly>
                    </div>  
                    <!--Botões-->
                    <div class="boxbutton">
                        <input type="submit" name="submit" id="submit" class="button">
                        <input type="reset" name="reset" id="reset" class="button" value="Limpar">
                    </div>
                    
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>