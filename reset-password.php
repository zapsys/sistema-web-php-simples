<?php
// Inicializa a sessão
session_start();

// Checa se o usuário já está logado, senão, redireciona-o para a página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Inclui o arquivo de configuração
require_once "config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processando os dados do formulário quando o mesmo é submetido
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Valida a nova senha
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Informe a nova senha.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = " A senha deve ter no mínimo 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Valida a confirmação de senha
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme a senha.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Senhas não conferem.";
        }
    }
    
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);
            
            // Atribui parâmetros
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Algo deu errado, tente novamente mais tarde.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Fecha conexão
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Loja de Informática - Alterar senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistema Loja de Informática">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body{ font: 14px sans-serif; }
    </style>
</head>
<body>
    <div class="d-flex flex-row align-items-center justify-content-center container-fluid" style="height: 100vh;">
        <div class="content p-3 border rounded">
            <h2 class="mb-3 text-center">Alterar senha</h2>
            <p class="mb-3 lead">Por favor preencha o formulário para alterar sua senha.</p>
            <?php 
            if(!empty($pass_alt)){
                echo '<div class="alert alert-success" role="alert">' . $pass_alt . '</div>';
            }        
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <div class="col-12 mb-3">
                    <label for="new_password" class="form-label">Nova senha</label>
                    <input id="new_password" type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div class="col-12 mb-3">
                    <label for="confirm_password" class="form-label">Confirme a senha</label>
                    <input id="confirm_password" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="row mb-3">
                    <div class="col-6 d-flex flex-column my-0">
                        <input type="submit" class="btn btn-primary" value="Enviar">
                    </div>
                    <div class="col-6 d-flex flex-column my-0">
                        <a class="btn btn-secondary" href="welcome.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>