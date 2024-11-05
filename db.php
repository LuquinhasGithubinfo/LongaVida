<?php
// Configurações de conexão ao banco de dados
$host = 'localhost';   // Nome do servidor, geralmente 'localhost'
$dbname = 'LongaVida'; // Nome do banco de dados
$username = 'root';    // Nome de usuário do banco de dados (mude se necessário)
$password = '';        // Senha do banco de dados (deixe em branco para xampp, ou mude conforme necessário)

try {
    // Cria a conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configura o modo de erro para exceções (útil para depuração)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Codificação UTF-8 para garantir que caracteres especiais sejam exibidos corretamente
    $pdo->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    // Se ocorrer algum erro na conexão, exibe a mensagem
    echo "Erro de conexão: " . $e->getMessage();
    exit;
}
?>
