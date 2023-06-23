<?php
// Inicializa a sessão
session_start();

// Checa se o usuário está logado senão redireciona para a página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
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
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar">
        <div class="container">
            <a class="navbar-brand" href="/">Sistema com cadastro e login em PHP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Sistema com cadastro e login em PHP</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Cadastro de clientes (F2)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Cadastro de produtos (F3)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Verificar estoque (F4)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Realizar Venda (F5)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#/">Configurações (F6)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ajuda (F1)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex flex-row align-items-center justify-content-center container-fluid">
        <div class="content">
            <h2 class="my-5">Olá, <b class="text-capitalize"><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Seja bem-vindo ao sistema!</h2>
            <p>
                <a href="reset-password.php" type="button" class="btn btn-warning">Alterar senha</a>
                <a href="logout.php" type="button" class="btn btn-danger ml-3">Deslogar</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>