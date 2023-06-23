<?php
/* Configuração dos parâmetros de acesso ao BD.
   Credenciais do banco de dados. 
*/
define('DB_SERVER', 'endereco_servidor_banco_de_dados');
define('DB_USERNAME', 'nome_usuario');
define('DB_PASSWORD', 'senha_do_banco');
define('DB_NAME', 'nome_do_banco');
 
// Tenta se conectar ao servidor e base de dados MySQL
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Checa a conexão
if($mysqli === false){
    die("ERRO: Não foi possível conectar com o banco de dados. " . $mysqli->connect_error);
}
?>