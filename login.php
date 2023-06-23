<?php
// Inicializa a sessão
session_start();

// Checa se o usuário já está logado, se sim, redireciona-o para a página 'welcome.php'
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Inclui o arquivo de configuração
require_once "config.php";

// Define variáveis e as inicializa sem valores
$username = $password = "";
$username_err = $password_err = $login_err = $pass_alt = "";

// Se o método é POST processa os dados vindos do formulário
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Checa se a variável 'username' é(está) vazia
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor informe o nome de usuário!";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Checa se a variável 'password' é(está) vazia
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor informe sua senha!";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valida as credenciais
    if(empty($username_err) && empty($password_err)){
        // Prepara uma busca no BD com o comando SELECT
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Vincula as variáveis à declaração preparada como parâmetros
            $stmt->bind_param("s", $param_username);
            
            // Atribui parâmetros
            $param_username = $username;
            
            // Tenta executar a declaração (statement) preparada
            if($stmt->execute()){
                // Guarda o resultado
                $stmt->store_result();
                
                // Checa se o usuário existe, se sim checa sua senha
                if($stmt->num_rows == 1){                    
                    // Vincula o resultado das variáveis
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Se a senha está correta inicia nova sessão
                            session_start();
                            
                            // Guarda os dados nas variáveis de sessão
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            $pass_alt = "Senha alterada com sucesso!";                           
                            
                            // Redireciona o usuário para a página de boas-vindas
                            header("location: welcome.php");
                        } else{
                            // Se a senha estiver incorreta apresenta mensagem de erro
                            $login_err = "Senha incorreta, verifique e tente novamnte!";
                        }
                    }
                } else{
                    // Se o usuário não exister apresenta mensagem de erro
                    $login_err = "Usuário não existe!";
                }
            } else{
                // Se o ocorrer algum outro erro apresenta uma mensagem genérica
                echo "Oops! Algo deu errado. Por favor tente mais tarde.";
            }

            // Fecha a declaração (statement)
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
    <title>Sistema com cadastro e login em PHP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistema com cadastro e login em PHP">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body{ font: 14px sans-serif; }
    </style>
</head>
<body>
    <div class="d-flex flex-row align-items-center justify-content-center container" style="height: 100vh;">
        <div class="content p-3 border rounded">
            <h2 class="mb-3 text-center">Acesso ao sistema</h2>
            <p class="mb-3 lead">Por favor informe suas credenciais para acessar.</p>

            <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger" role="alert">' . $login_err . '</div>';
            }
            else if(!empty($reg_success)){
                echo '<div class="alert alert-success" role="alert">' . $reg_success . '</div>';
            }        
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="col-12 mb-3">
                    <label for="username" class="form-label">Usuário</label>
                    <input id="username" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="col-12 mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input id="password" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="row mb-3">
                    <div class="col-12 d-flex flex-column my-0">
                        <input type="submit" class="btn btn-primary" value="Acessar">
                    </div>
                </div>
                <p>Não tem conta? <a href="register.php">Registre-se</a></p>
            </form>
        </div>
    </div>
</body>
</html>