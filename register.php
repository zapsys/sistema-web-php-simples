<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $reg_success = "";
$username_err = $password_err = $confirm_password_err = "";

// Se o método é POST processa os dados vindos do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valida o usuário
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor informe um usuário.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "O usuário só pode conter letras, números e underscore";
    } else {
        // Prepara uma declaração de busca com o comando SELECT
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Vincula as variáveis à declaração preparada como parâmetros
            $stmt->bind_param("s", $param_username);

            // Atribui parâmetros
            $param_username = trim($_POST["username"]);

            // Tenta executar a declaração preparada
            if ($stmt->execute()) {
                // Guarda o resultado
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "Este usuário já existe!";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                // Se o ocorrer algum outro erro apresenta uma mensagem genérica
                echo "Oops! Algo deu errado, tente novamente mais tarde.";
            }
            // Fecha a declaração
            $stmt->close();
        }
    }
    // Valida se o campo 'senha' não está vazio e seu tamanho mínimo
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor informe uma senha.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = " A senha deve possuir no mínimo 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }
    // Valida se o campo 'confirmar_senha' não está vazio e se é igual ao campo 'senha'
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Por favor confirme a senha.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Senhas não conferem.";
        }
    }
    // Checa por erros de input (sem valores/dados inválidos) antes de inserir na base de dados
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepara uma declaração com o comando INSERT
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Vincula as variáveis à declaração preparada como parêmetros
            $stmt->bind_param("ss", $param_username, $param_password);

            // Atribui parâmetros
            $param_username = $username;
            // Cria um hash da senha
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Tenta executar a declaração preparada
            if ($stmt->execute()) {
                // Redireciona para a tela de login
                header("location: login.php");
            } else {
                echo "Oops! Algo deu errado, tente novamente mais tarde.";
            }
            // Fecha a declaração
            $stmt->close();
        }
    }
    // Fecha a conexão
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Sistema de cadastro com login em PHP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistema com cadastro e login em PHP">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            font: 14px sans-serif;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-row align-items-center justify-content-center container-fluid" style="height: 100vh;">
        <div class="content p-3 border rounded">
            <h2 class="mb-3 text-center">Cadastro</h2>
            <p class="mb-3 lead">Preencha o formulário abaixo para criar uma conta.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="col-12 mb-3">
                    <label for="username" class="form-label">Usuário</label>
                    <input id="username" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback">
                        <?php echo $username_err; ?>
                    </span>
                </div>
                <div class="col-12 mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input id="password" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback">
                        <?php echo $password_err; ?>
                    </span>
                </div>
                <div class="col-12 mb-3">
                    <label for="confirm_password" class="form-label">Confirme a senha</label>
                    <input id="confirm_password" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback">
                        <?php echo $confirm_password_err; ?>
                    </span>
                </div>
                <div class="row mb-3">
                    <div class="col-6 d-flex flex-column my-0">
                        <input type="submit" class="btn btn-primary" value="Confirmar">
                    </div>
                    <div class="col-6 d-flex flex-column my-0">
                        <input type="reset" class="btn btn-secondary" value="Limpar">
                    </div>
                </div>
                <p>Já tem uma conta? <a href="login.php">Faça o login aqui</a></p>
            </form>
        </div>
    </div>
</body>
</html>