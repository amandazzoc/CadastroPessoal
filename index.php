<?php
    include_once('config.php');
    function validateCpf($cpf)
    {
        //troca tudo o que não for número para nada
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        //se não tiver 11 digitos será falso
        if (strlen($cpf) != 11){
            return false;
        }
        //calculo para a validação do cpf
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
        //calcula a soma dos nove primeiros dígitos do CPF multiplicados pelos pesos (de 10 a 2)
            $soma += $cpf[$i] * $j;
        //calcula o resto da divisão da soma por 11
            $resto = $soma % 11;
        //verifica se o dígito verificador 1 (posição 10) é válido
        if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto))
        {
            return false;
        }
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf[$i] * $j;
            $resto = $soma % 11;
            return $cpf[10] == ($resto < 2 ? 0 : 11 - $resto);
    }

    if(isset($_POST['submit']))
    {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $estado_civil = $_POST['estado_civil'];
        $endereco = $_POST['endereco'];
        $estado = $_POST['estado'];
        $municipio = $_POST['municipio'];
        $num = $_POST['num'];
        $cep = $_POST['cep'];
        //calcula a idade com base na data de nascimento
        $data_nascimento = $_POST['data_nascimento'];
        $data_nascimento_formatada = date("Y-m-d", strtotime($data_nascimento)); // Formata a data para o formato do MySQL
        $hoje = new DateTime();
        $idade = $hoje->diff(new DateTime($data_nascimento))->y;

        // Verifica se o e-mail tem um formato válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "E-mail inválido!";
        }
        // Verifica se o cep é valido
        if(!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) {
            $errors['cep'] = "CEP inválido!";
        }
        // Verifica se o cpf é valido
        if (!validateCpf($cpf)) {
            $errors['cpf'] = "CPF inválido!";
        } else {
        //Manda os dados para o banco
        $result = mysqli_query($conexao, "INSERT INTO usuarios(nome,cpf,email,telefone,estado_civil,endereco,cep,data_nascimento,idade,estado,municipio,num) VALUES ('".$_POST['nome']."','".$_POST['cpf']."','".$_POST['email']."','".$_POST['telefone']."','".$_POST['estado_civil']."','".$_POST['endereco']."','".$_POST['cep']."','".$data_nascimento_formatada."','".$idade."','".$_POST['estado']."','".$_POST['municipio']."','".$_POST['num']."')");
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Cadastro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="js/script.js"></script>
</head>

<body>
    <div class="box">
        <!-- Popup -->
        <div class="popup" id="popup">
            <div class="popup-content">
                <p id="popup-message"></p>
                <button id="close-popup">Fechar</button>
            </div>
        </div>
        <div class="img-box">
            <img src="imgs/singup.svg">
        </div>
        <div class="form-box">
            <div class="title">
                <h1>Cadastre-se</h1>
            </div>
            <form action="index.php" method="POST">
                <!--Nome Completo-->
                <div class="inputbox">
                    <label for="nome" class="label">Nome Completo:</label>
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                </div>

                <!--Email-->
                <div class="inputbox">
                    <label for="email" class="label">Email:</label>
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <?php if(isset($errors['email'])) { echo '<span class="error">'.$errors['email'].'</span>'; } ?>
                </div>
                <!--CPF-->
                <div class="inputbox w50">
                    <label for="cpf" class="label">CPF:</label>
                    <input type="text" name="cpf" id="cpf" class="inputUser cpf" required>
                    <?php if(isset($errors['cpf'])) { echo '<span class="error">'.$errors['cpf'].'</span>'; } ?>
                </div>
                <!--Telefone-->
                <div class="inputbox w50">
                    <label for="telefone" class="label">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" class="inputUser" required>
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
                <div class="inputbox w80">
                    <!--Data de Nascimento-->
                    <label for="data_nascimento" class="label">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" class="formatbox date" required>
                </div>

                <!--Idade-->
                <div class="inputbox w20">
                    <label for="idade" class="label">Idade: </label>
                    <input id="idade" name="idade" class="inputUser" value="<?php echo isset($idade) ? $idade : ''; ?>"
                        reandoly style="cursor: not-allowed;">
                </div>
                <!--CEP-->
                <div class="inputbox">
                    <label for="cep" class="label">CEP:</label>
                    <input type="text" name="cep" id="cep" class="inputUser" required>
                    <?php if(isset($errors['cep'])) { echo '<span class="error">'.$errors['cep'].'</span>'; } ?>

                </div>
                <!--Estado-->
                <div class="inputbox w50">
                    <label for="estado" class="label">Estado:</label>
                    <select class="formatbox" id="estado" name="estado">
                    </select>
                </div>
                <!--Municipio-->
                <div class="inputbox w50 ">
                    <label for="municipio" class="label">Municipio:</label>
                    <select class="formatbox" id="municipio" name="municipio">
                    </select>
                </div>

                <!--Endereço-->
                <div class="inputbox w80">
                    <label for="endereco" class="label">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" class="inputUser" required>
                </div>
                <!--Numero-->
                <div class="inputbox w20">
                    <label for="num" class="label">Número:</label>
                    <input type="text" id="num" name="num" class="inputUser" required>
                </div>

                <!--Botões-->
                <div class="inputbutton">
                    <input type="submit" name="submit" id="submit" class="buttone w48" value="Salvar">
                    <input type="reset" name="reset" id="reset" class="buttonc w48" value="Cancelar">
                </div>



            </form>
        </div>
    </div>
    <script>

        // Função para preencher estado e município automaticamente
        function preencherEstadoMunicipio(cep) {
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
                if (!data.erro) {
                    $('#estado').val(data.uf);
                    if (data.localidade) {
                        $('#municipio').empty().append($('<option>', { value: data.localidade, text: data.localidade }));
                    } else {
                        console.log('Município não encontrado para o CEP informado.');
                    }
                } else {
                    console.log('CEP inválido.');
                }
            });
        }


        // Adiciona um evento change no campo de CEP
        $('#cep').change(function () {
            var cep = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos do CEP
            if (cep.length === 8) {
                preencherEstadoMunicipio(cep);
            }
        });
    </script>
</body>
</html>